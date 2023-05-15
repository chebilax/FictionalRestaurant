'use strict';

function confirmDeleteBooking(event) {
    const deleteUrl = event.currentTarget.getAttribute('href');
    const confirmation = confirm('Êtes-vous sûr de vouloir supprimer cette réservation ?');
    if (confirmation) {
        window.location.href = deleteUrl;
    } else {
        event.preventDefault();
    }
}

function validateBookingForm(event) {
    const bookingDateInput = document.getElementById('bookingDate');
    const bookingTimeInput = document.getElementById('bookingTime');
    const now = new Date();
    const selectedDate = new Date(`${bookingDateInput.value}T${bookingTimeInput.value}:00`);

    if (selectedDate < now) {
        event.preventDefault();
        alert('Vous ne pouvez pas réserver à une date antérieure à maintenant.');
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const deleteButtons = document.querySelectorAll('.deleteBookingButton');

    deleteButtons.forEach((deleteButton) => {
        deleteButton.addEventListener('click', confirmDeleteBooking);
    });

    const bookingForm = document.getElementById('bookingForm');
    bookingForm.addEventListener('submit', validateBookingForm);
});
