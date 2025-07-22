// === ADD MODAL ===

document.addEventListener('DOMContentLoaded', function() {

  document.getElementById('openAddModal').addEventListener('click', function() {
    document.getElementById('addModal').style.display = 'flex';
  });

  const addLocation = document.getElementById('add_location');
  const addSeatNum = document.getElementById('add_seat_num');
  const seatLimitAlert = document.getElementById('seatLimitAlert');
  const saveBtn = document.querySelector('#addModal button[type="submit"]');

  addLocation.addEventListener('change', function() {
    const location = this.value;

    if (location) {
         fetch(`/admin/seats/next-seat-number/${encodeURIComponent(location)}`)
        .then(response => response.json())
        .then(data => {
          addSeatNum.value = data.next_seat_num;

          if (data.limit_reached) {
            seatLimitAlert.style.display = 'block';
            saveBtn.disabled = true;
          } else {
            seatLimitAlert.style.display = 'none';
            saveBtn.disabled = false;
          }
        })
        .catch(err => console.error(err));
    } else {
      addSeatNum.value = '';
      seatLimitAlert.style.display = 'none';
      saveBtn.disabled = false;
    }
  });
});




function closeAddModal() {
  document.getElementById('addModal').style.display = 'none';
}


// === UPDATE MODAL ===
function openUpdateModal(id, seatNum, location) {
  const form = document.getElementById('updateSeatForm');
  form.action = `/admin/seats/${id}`;
  document.getElementById('update_seat_id').value = id;
  document.getElementById('update_seat_num').value = seatNum;
  document.getElementById('update_location').value = location;
  document.getElementById('updateModal').style.display = 'flex';
}

function closeUpdateModal() {
  document.getElementById('updateModal').style.display = 'none';
}

window.addEventListener('click', function(e) {
  if (e.target.classList.contains('modal')) {
    e.target.style.display = 'none';
  }
});


//Combine location filter and search filter
function filterSeats() {
  const locationFilter = document.getElementById('locationFilter').value.trim();
  const searchQuery = document.getElementById('searchInput').value.toLowerCase();
  let visibleCount = 0;

  document.querySelectorAll('#seatsTable tbody tr').forEach(row => {
    if (row.id === 'noResults') return;

    const seatNum = row.cells[0].textContent.toLowerCase();
    const location = row.cells[1].textContent.trim();

    const matchesSearch = seatNum.includes(searchQuery);
    const matchesLocation = !locationFilter || location === locationFilter;

    if (matchesSearch && matchesLocation) {
      row.style.display = '';
      visibleCount++;
    } else {
      row.style.display = 'none';
    }
  });

  document.getElementById('noResults').style.display = visibleCount === 0 ? '' : 'none';
}

document.getElementById('locationFilter').addEventListener('change', filterSeats);
document.getElementById('searchInput').addEventListener('input', filterSeats);



