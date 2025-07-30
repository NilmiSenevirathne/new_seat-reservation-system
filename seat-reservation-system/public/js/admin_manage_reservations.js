document.addEventListener('DOMContentLoaded', function () {
  // Elements
  const editModal = document.getElementById('editReservationModal');
  const newModal = document.getElementById('newReservationModal');

  const editButtons = document.querySelectorAll('.edit-btn');
  const editCloseBtn = document.getElementById('editModalClose');
  const newCloseBtn = document.getElementById('newModalClose');
  const openNewBtn = document.getElementById('openNewReservationBtn');

  // Open Edit Modal and load reservation data
  editButtons.forEach(button => {
    button.addEventListener('click', () => {
      const reserveId = button.getAttribute('data-id');

      fetch(`/admin/managereservations/${reserveId}/edit`)
        .then(response => response.json())
        .then(data => {
          document.getElementById('edit_reserve_id').value = data.reserve_id;
          document.getElementById('edit_status').value = data.status;
          document.getElementById('edit_date').value = data.reservation_date;

          // Set form action URL dynamically
          document.getElementById('editReservationForm').action = `/admin/managereservations/${data.reserve_id}`;

          editModal.style.display = 'block';
        })
        .catch(err => {
          alert('Failed to load reservation data.');
          console.error(err);
        });
    });
  });

  // Open New Reservation Modal
  openNewBtn.addEventListener('click', () => {
    newModal.style.display = 'block';
  });

  // Close modals
  editCloseBtn.addEventListener('click', () => {
    editModal.style.display = 'none';
  });

  newCloseBtn.addEventListener('click', () => {
    newModal.style.display = 'none';
  });

  // Close modals when clicking outside modal content
  window.addEventListener('click', (event) => {
    if (event.target === editModal) {
      editModal.style.display = 'none';
    }
    if (event.target === newModal) {
      newModal.style.display = 'none';
    }
  });

});
