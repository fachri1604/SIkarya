const body = document.querySelector("body"),
      modeToggle = body.querySelector(".mode-toggle");
      sidebar = body.querySelector("nav");
      sidebarToggle = body.querySelector(".sidebar-toggle");

let getMode = localStorage.getItem("mode");
if(getMode && getMode ==="dark"){
    body.classList.toggle("dark");
}

let getStatus = localStorage.getItem("status");
if(getStatus && getStatus ==="close"){
    sidebar.classList.toggle("close");
}

modeToggle.addEventListener("click", () =>{
    body.classList.toggle("dark");
    if(body.classList.contains("dark")){
        localStorage.setItem("mode", "dark");
    }else{
        localStorage.setItem("mode", "light");
    }
});

sidebarToggle.addEventListener("click", () => {
    sidebar.classList.toggle("close");
    if(sidebar.classList.contains("close")){
        localStorage.setItem("status", "close");
    }else{
        localStorage.setItem("status", "open");
    }
})

// card //

document.addEventListener('DOMContentLoaded', function () {
    let projects = JSON.parse(localStorage.getItem('projects')) || [];
    let cardList = document.querySelector('.card-list');

    // Loop melalui semua project dan buat card
    projects.forEach(function (project) {
        let cardItem = document.createElement('div');
        cardItem.classList.add('card-item');

        cardItem.innerHTML = `
            <img src="images/${project.profileImage}" alt="${project.title}" />
            <h3>${project.title}</h3>
            <div class="actions">
                <button class="edit-btn" onclick="editProject('${project.id}')">Edit</button>
                <button class="delete-btn" onclick="deleteProject('${project.id}')">Delete</button>
            </div>
        `;

        cardList.appendChild(cardItem);
    });
});

// Fungsi Edit Project
function editProject(projectId) {
    // Redirect ke content.html dengan projectId sebagai parameter untuk diedit
    window.location.href = content.html?edit=$:{projectId};
}

// Fungsi Delete Project
function deleteProject(projectId) {
    let projects = JSON.parse(localStorage.getItem('projects')) || [];
    projects = projects.filter(project => project.id !== projectId);
    localStorage.setItem('projects', JSON.stringify(projects));
    alert("Project Deleted");
    location.reload(); // Refresh halaman untuk mencerminkan perubahan
}