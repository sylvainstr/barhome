document.addEventListener("DOMContentLoaded", () => {
  const deleteBtn = document.querySelector(".button-bar-delete");
  const dropItems = document.querySelector(".delete-message");
  const cancelDelete = document.querySelector("#cancel-delete");

  deleteBtn.addEventListener("click", () => {
      toggleDisplay(dropItems);
  });

  cancelDelete.addEventListener("click", () => {
    toggleDisplay(dropItems);
  });

  const toggleDisplay = (item) => {
    if (item.style.display === "none" || item.style.display === "") {
      item.style.display = "block";
    } else {
      item.style.display = "none";
    }
  };
});
