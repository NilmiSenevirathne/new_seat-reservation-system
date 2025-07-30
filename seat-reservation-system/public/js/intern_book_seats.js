document.addEventListener('DOMContentLoaded', function () {
  const overlay = document.querySelector('.overlay');
  const popup = document.getElementById('popup');
  const popupSeat = document.getElementById('popup-seat');
  const confirmBtn = document.getElementById('confirm-booking');
  const closeBtn = document.getElementById('close-popup');
  const dateInput = document.getElementById('date');
  const timeSlotSelect = document.getElementById('time-slot'); // Time slot selector in popup

  let selectedSeatId = null;
  let selectedSeatNum = null;

  // Attach click only to available seats
  document.querySelectorAll('.seat.available').forEach(seat => {
    seat.addEventListener('click', function () {
      selectedSeatId = this.dataset.seatId;
      selectedSeatNum = this.dataset.seatNum;

      popupSeat.textContent = `Seat: ${selectedSeatNum}`;

      // Reset time slot selection on popup open
      if (timeSlotSelect) {
        timeSlotSelect.value = '';
      }

      overlay.style.display = 'block';
      popup.style.display = 'block';
    });
  });

  confirmBtn.addEventListener('click', function () {
    if (!selectedSeatId) return;

    const selectedDate = dateInput.value;
    if (!selectedDate) {
      alert('Please select a valid date.');
      return;
    }

    const selectedTimeSlot = timeSlotSelect ? timeSlotSelect.value : '';
    if (!selectedTimeSlot) {
      alert('Please select a time slot.');
      return;
    }

    if (confirm(`Are you sure you want to book seat ${selectedSeatNum} for ${selectedDate} at ${selectedTimeSlot}?`)) {
      confirmBtn.disabled = true;

      fetch(bookingUrl, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
          seat_id: selectedSeatId,
          date: selectedDate,
          time_slot: selectedTimeSlot
        })
      })
      .then(async response => {
        if (!response.ok) {
          const text = await response.text();
          console.error('Server error:', text);
          throw new Error('Server returned an error.');
        }
        return response.json();
      })
      .then(data => {
        alert(data.message);
        if (data.success) {
          window.location.reload();
        } else {
          confirmBtn.disabled = false;
        }
      })
      .catch(error => {
        console.error('Booking failed:', error);
        alert('An error occurred while booking.');
        confirmBtn.disabled = false;
      });

      closePopup();
    }
  });

  closeBtn.addEventListener('click', closePopup);
  overlay.addEventListener('click', closePopup);

  function closePopup() {
    overlay.style.display = 'none';
    popup.style.display = 'none';
    confirmBtn.disabled = false;
    selectedSeatId = null;
    selectedSeatNum = null;
    if (timeSlotSelect) {
      timeSlotSelect.value = '';
    }
  }
});
