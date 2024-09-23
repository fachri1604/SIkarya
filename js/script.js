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


// content form //
document.getElementById('projectForm').addEventListener('submit', function (e) {
    e.preventDefault();

    // Ambil data dari form
    let projectId = document.getElementById('projectId').value;
    let projectTitle = document.getElementById('projectTitle').value;
    let projectDescription = document.getElementById('projectDescription').value;
    let studentName = document.getElementById('studentName').value;
    let studentNim = document.getElementById('studentNim').value;
    let profileImage = document.getElementById('profileImage').files[0].name;
    let mainImage = document.getElementById('mainImage').files[0].name;

    // Cek apakah project sedang diedit
    let isEditing = document.getElementById('projectId').dataset.editing === "true";

    // Ambil data projects dari localStorage
    let projects = JSON.parse(localStorage.getItem('projects')) || [];

    if (isEditing) {
        // Update project yang sedang diedit
        projects = projects.map(project => {
            if (project.id === projectId) {
                return {
                    id: projectId,
                    title: projectTitle,
                    description: projectDescription,
                    studentName: studentName,
                    studentNim: studentNim,
                    profileImage: profileImage,
                    mainImage: mainImage
                };
            }
            return project;
        });
        document.getElementById('projectId').dataset.editing = "false"; // Reset editing state
    } else {
        // Tambah project baru
        let project = {
            id: projectId,
            title: projectTitle,
            description: projectDescription,
            studentName: studentName,
            studentNim: studentNim,
            profileImage: profileImage,
            mainImage: mainImage
        };
        projects.push(project);
    }

    localStorage.setItem('projects', JSON.stringify(projects));
    alert("Project Saved!");
    document.getElementById('projectForm').reset();
});

// Fungsi untuk mengisi form saat melakukan edit
function loadProjectToForm(projectId) {
    let projects = JSON.parse(localStorage.getItem('projects')) || [];
    let project = projects.find(project => project.id === projectId);

    if (project) {
        document.getElementById('projectId').value = project.id;
        document.getElementById('projectTitle').value = project.title;
        document.getElementById('projectDescription').value = project.description;
        document.getElementById('studentName').value = project.studentName;
        document.getElementById('studentNim').value = project.studentNim;
        // Note: Images cannot be pre-filled in file inputs due to security reasons
        document.getElementById('projectId').dataset.editing = "true"; // Set editing state
    }
}