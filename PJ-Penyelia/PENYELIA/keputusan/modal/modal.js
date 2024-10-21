// Get modal element
var modal = document.getElementById("myModal");

// Get button that opens the modal
var btn = document.getElementById("openModalBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// Get the button inside the modal
var modalButton = document.querySelector(".modal-button");

// When the user clicks the button, open the modal
btn.onclick = function () {
  modal.style.display = "block";
  modal.classList.add("show");
};

// When the user clicks on <span> (x), close the modal
span.onclick = closeModal;

// When the user clicks the button inside the modal, close the modal
modalButton.onclick = closeModal;

// When the user clicks anywhere outside of the modal, close it
window.onclick = function (event) {
  if (event.target == modal) {
    closeModal();
  }
};

function closeModal() {
  modal.classList.remove("show");
  modal.style.display = "none"; // Immediately hide the modal
}
