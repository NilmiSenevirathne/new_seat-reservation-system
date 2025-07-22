document.addEventListener('DOMContentLoaded', function() {
  const sidebar = document.getElementById('sidebar');
  const sidebarToggle = document.getElementById('sidebarToggle');

  sidebarToggle.addEventListener('click', function(e) {
    e.stopPropagation();
    sidebar.classList.toggle('active');
  });

  document.addEventListener('click', function(e) {
    if (window.innerWidth <= 768 &&
        !sidebar.contains(e.target) &&
        e.target !== sidebarToggle) {
      sidebar.classList.remove('active');
    }
  });

  // Fallback: highlight active based on URL
  const currentUrl = window.location.href;
  const links = document.querySelectorAll('.menu-link');
  links.forEach(link => {
    if (link.href === currentUrl) {
      link.parentElement.classList.add('active');
    }

    link.addEventListener('click', function() {
      if (window.innerWidth <= 768) {
        sidebar.classList.remove('active');
      }
    });
  });
});
