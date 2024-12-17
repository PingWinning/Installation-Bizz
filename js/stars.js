window.onload = function() {
    // Get the current year
    const currentYear = new Date().getFullYear();

    // Find the element with the ID 'year' and input the year
    document.getElementById('year').textContent = currentYear;
};
