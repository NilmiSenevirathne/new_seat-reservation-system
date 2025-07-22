
  document.addEventListener('DOMContentLoaded', function() {
    const userInfo = document.querySelector('.user-info');
    const dropdown = document.getElementById('userDropdown');

    userInfo.addEventListener('click', function(e) {
      e.stopPropagation();
      dropdown.style.display = dropdown.style.display === 'flex' ? 'none' : 'flex';
    });

    // Hide dropdown when clicking outside
    document.addEventListener('click', function() {
      dropdown.style.display = 'none';
    });
  });

