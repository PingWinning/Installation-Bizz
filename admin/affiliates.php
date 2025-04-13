<?php
session_start();
include('../includes/config.php');

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Handle contract/status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_id'])) {
    $id = intval($_POST['update_id']);
    $contract_sent = $_POST['contract_sent'] === 'Yes' ? 1 : 0;
    $contract_signed = $_POST['contract_signed'] === 'Yes' ? 1 : 0;
    $sales_received = $_POST['sales_received'] === 'Yes' ? 1 : 0;
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE affiliates SET contract_sent=?, contract_signed=?, sales_contract_received=?, status=? WHERE id=?");
    $stmt->bind_param("iiisi", $contract_sent, $contract_signed, $sales_received, $status, $id);
    $stmt->execute();
    $stmt->close();
    $_SESSION['update_success'] = "Affiliate #$id updated successfully.";
    header("Location: affiliates.php");
    exit();
}

// Filter logic and pagination
$search = $_GET['search'] ?? '';
$filter = $_GET['status'] ?? '';
$page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

$where = "WHERE (first_name LIKE ? OR last_name LIKE ? OR email LIKE ? OR phone LIKE ?)";
$params = ["%$search%", "%$search%", "%$search%", "%$search%"];

if ($filter !== '') {
    $where .= " AND status = ?";
    $params[] = $filter;
}

$countStmt = $conn->prepare("SELECT COUNT(*) FROM affiliates $where");
$types = str_repeat('s', count($params));
$countStmt->bind_param($types, ...$params);
$countStmt->execute();
$countStmt->bind_result($totalResults);
$countStmt->fetch();
$countStmt->close();
$totalPages = ceil($totalResults / $limit);

$sql = "SELECT * FROM affiliates $where LIMIT ? OFFSET ?";
$params[] = $limit;
$params[] = $offset;
$types .= 'ii';

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();
$affiliates = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Affiliate Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 text-white min-h-screen">
    <nav class="bg-gray-800 p-4">
        <div class="container mx-auto flex justify-between items-center">
            <div class="text-lg font-semibold text-white">Admin Dashboard</div>
            <ul class="flex space-x-6 text-white">
                <li><a href="index.php" class="hover:text-blue-400">Home</a></li>
                <li><a href="schedule.php" class="hover:text-blue-400">Schedule</a></li>
                <li><a href="#" class="hover:text-blue-400">Bookings</a></li>
            </ul>
            <button onclick="logout()"
                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Logout</button>
        </div>
    </nav>

    <main class="p-6">
        <?php if (isset($_SESSION['update_success'])): ?>
            <div class="mb-4 p-3 rounded bg-green-700 text-white text-sm font-medium">
                <?= $_SESSION['update_success'];
                unset($_SESSION['update_success']); ?>
            </div>
        <?php endif; ?>

        <form method="GET"
            class="flex flex-col sm:flex-row justify-end items-center mb-4 space-y-2 sm:space-y-0 sm:space-x-4">
            <input type="text" name="search" placeholder="Search..." value="<?= htmlspecialchars($search) ?>"
                class="bg-gray-700 px-4 py-2 rounded text-white" />
            <select name="status" class="bg-gray-700 px-4 py-2 rounded text-white">
                <option value="">All Statuses</option>
                <?php
                $statuses = ['Pending', 'Approved', 'Rejected', 'Suspended', 'Banned'];
                foreach ($statuses as $s) {
                    $selected = $filter === $s ? 'selected' : '';
                    echo "<option value=\"$s\" $selected>$s</option>";
                }
                ?>
            </select>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded">Filter</button>
        </form>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-gray-800 rounded-lg">
                <thead>
                    <tr class="text-left border-b border-gray-700">
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">First Name</th>
                        <th class="px-4 py-2">Last Name</th>
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2">Phone (Optional)</th>
                        <th class="px-4 py-2">Contract Sent</th>
                        <th class="px-4 py-2">Contract Signed</th>
                        <th class="px-4 py-2">Sales Contract Received</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($affiliates as $a): ?>
                        <tr class="border-b border-gray-700">
                            <form method="POST">
                                <input type="hidden" name="update_id" value="<?= $a['id'] ?>">
                                <td class="px-4 py-2 font-mono text-gray-400">#<?= $a['id'] ?></td>
                                <td class="px-4 py-2"><?= htmlspecialchars($a['first_name']) ?></td>
                                <td class="px-4 py-2"><?= htmlspecialchars($a['last_name']) ?></td>
                                <td class="px-4 py-2"><?= htmlspecialchars($a['email']) ?></td>
                                <td class="px-4 py-2"><?= htmlspecialchars($a['phone']) ?></td>
                                <td class="px-4 py-2">
                                    <select name="contract_sent" class="bg-gray-700 text-white px-2 py-1 rounded">
                                        <option <?= !$a['contract_sent'] ? 'selected' : '' ?>>No</option>
                                        <option <?= $a['contract_sent'] ? 'selected' : '' ?>>Yes</option>
                                    </select>
                                </td>
                                <td class="px-4 py-2">
                                    <select name="contract_signed" class="bg-gray-700 text-white px-2 py-1 rounded">
                                        <option <?= !$a['contract_signed'] ? 'selected' : '' ?>>No</option>
                                        <option <?= $a['contract_signed'] ? 'selected' : '' ?>>Yes</option>
                                    </select>
                                </td>
                                <td class="px-4 py-2">
                                    <select name="sales_received" class="bg-gray-700 text-white px-2 py-1 rounded">
                                        <option <?= !$a['sales_contract_received'] ? 'selected' : '' ?>>No</option>
                                        <option <?= $a['sales_contract_received'] ? 'selected' : '' ?>>Yes</option>
                                    </select>
                                </td>
                                <td class="px-4 py-2">
                                    <select name="status" class="bg-gray-700 text-white px-2 py-1 rounded">
                                        <?php foreach ($statuses as $status): ?>
                                            <option value="<?= $status ?>" <?= $a['status'] === $status ? 'selected' : '' ?>>
                                                <?= $status ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td class="px-4 py-2">
                                    <button class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-1 rounded"
                                        type="submit">Update</button>
                                </td>
                            </form>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <?php if ($totalPages > 1): ?>
            <div class="mt-6 flex justify-center space-x-2">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="?search=<?= urlencode($search) ?>&status=<?= urlencode($filter) ?>&page=<?= $i ?>"
                        class="px-3 py-1 rounded <?= $i === $page ? 'bg-blue-600' : 'bg-gray-700 hover:bg-gray-600' ?>">
                        <?= $i ?>
                    </a>
                <?php endfor; ?>
            </div>
        <?php endif; ?>
    </main>
    <script>
        function logout() {
            window.location.href = 'logout.php';
        }
    </script>
</body>

</html>