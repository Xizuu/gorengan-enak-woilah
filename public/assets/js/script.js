const burgerBtn = document.getElementById("burgerBtn");
const sidebar = document.getElementById("sidebar");
const overlay = document.getElementById("overlay");

$(document).ready(function () {
  $("#users-table").DataTable({
    pageLength: 10,
    lengthMenu: [10, 20, 50],
    language: {
      search: "Search:",
      lengthMenu: "Show _MENU_ entries",
      info: "Showing _START_ to _END_ of _TOTAL_ users",
      paginate: {
        first: "<i class='fas fa-angle-double-left'></i>",
        previous: "<i class='fas fa-angle-left'></i>",
        next: "<i class='fas fa-angle-right'></i>",
        last: "<i class='fas fa-angle-double-right'></i>",
      },
    },
  });
});

function openSidebar() {
  sidebar.classList.remove("-translate-x-full");
  overlay.classList.remove("hidden");
  document.body.style.overflow = "hidden";
}

function closeSidebar() {
  sidebar.classList.add("-translate-x-full");
  overlay.classList.add("hidden");
  document.body.style.overflow = "";
}

burgerBtn.addEventListener("click", () => {
  if (sidebar.classList.contains("-translate-x-full")) {
    openSidebar();
  } else {
    closeSidebar();
  }
});

overlay.addEventListener("click", () => {
  closeSidebar();
});

const userToggle = document.getElementById("userToggle");
const dropdownMenu = document.getElementById("dropdownMenu");

userToggle.addEventListener("click", () => {
  dropdownMenu.classList.toggle("hidden");
});

// Close sidebar on window resize if desktop
window.addEventListener("resize", () => {
  if (window.innerWidth >= 640) {
    sidebar.classList.remove("-translate-x-full");
    overlay.classList.add("hidden");
    document.body.style.overflow = "";
  } else {
    sidebar.classList.add("-translate-x-full");
  }
});
