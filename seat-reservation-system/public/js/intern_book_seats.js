document.addEventListener('DOMContentLoaded', function () {
  const overlay = document.querySelector('.overlay');
  const popup = document.getElementById('popup');
  const popupSeat = document.getElementById('popup-seat');
  let selectedSeatId = null;
  let selectedSeatNum = null;

  document.querySelectorAll('.seat.available').forEach(seat => {
    seat.addEventListener('click', function() {
      selectedSeatId = this.dataset.seatId;
      selectedSeatNum = this.dataset.seatNum;

      popupSeat.textContent = "Seat: " + selectedSeatNum;
      overlay.style.display = 'block';
      popup.style.display = 'block';
    });
  });

  document.getElementById('confirm-booking').addEventListener('click', function() {
    if (confirm(`Are you sure you want to book seat ${selectedSeatNum}?`)) {
      fetch(bookingUrl, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json', // VERY IMPORTANT!
          'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
          seat_id: selectedSeatId,
          date: document.getElementById('date').value
        })
      })
      .then(async response => {
        if (!response.ok) {
          const text = await response.text();
          console.error('Server error:', text);
          throw new Error('Server returned error');
        }
        return response.json();
      })
      .then(data => {
        alert(data.message);
        if (data.success) {
          window.location.reload();
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while booking.');
      });
    }

    closePopup();
  });

  document.getElementById('close-popup').addEventListener('click', closePopup);
  overlay.addEventListener('click', closePopup);

  function closePopup() {
    overlay.style.display = 'none';
    popup.style.display = 'none';
  }
});
