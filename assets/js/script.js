document.addEventListener("DOMContentLoaded", () => {
    const studentTable = document.getElementById("student-table");

    // Simulating fetching from backend
    let students = [
        { id: 1, name: "John Doe", year: "2025", course: "MIS", nationality: "Ghanaian", engagement: "Conference", status: "Pending" },
        { id: 2, name: "Jane Smith", year: "2024", course: "Computer Science", nationality: "Nigerian", engagement: "Exchange", status: "Approved" },
        { id: 3, name: "Michael Lee", year: "2023", course: "Business Admin", nationality: "South African", engagement: "Internship", status: "Rejected" }
    ];

    function updateStats() {
        document.getElementById("total-students").querySelector(".number").textContent = students.length;
        document.getElementById("approved").querySelector(".number").textContent = students.filter(s => s.status === "Approved").length;
        document.getElementById("pending").querySelector(".number").textContent = students.filter(s => s.status === "Pending").length;
        document.getElementById("rejected").querySelector(".number").textContent = students.filter(s => s.status === "Rejected").length;
    }

    function renderTable() {
        studentTable.innerHTML = "";
        students.forEach((student, index) => {
            studentTable.innerHTML += `
                <tr>
                    <td>${student.name}</td>
                    <td>${student.year}</td>
                    <td>${student.course}</td>
                    <td>${student.nationality}</td>
                    <td>${student.engagement}</td>
                    <td>
                        <select onchange="updateStatus(${index}, this.value)">
                            <option value="Approved" ${student.status === "Approved" ? "selected" : ""}>Approved</option>
                            <option value="Pending" ${student.status === "Pending" ? "selected" : ""}>Pending</option>
                            <option value="Rejected" ${student.status === "Rejected" ? "selected" : ""}>Rejected</option>
                        </select>
                    </td>
                </tr>`;
        });
        updateStats();
    }

    window.updateStatus = (index, newStatus) => {
        students[index].status = newStatus;
        updateStats();
    };

    renderTable();
});
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('announcementForm');
    const titleInput = document.getElementById('announcementTitle');
    const contentInput = document.getElementById('announcementContent');
    const announcementList = document.getElementById('announcements');

    // Load announcements from localStorage when the page loads
    const storedAnnouncements = JSON.parse(localStorage.getItem('announcements')) || [];
    storedAnnouncements.forEach(announcement => {
        addAnnouncementToPage(announcement.title, announcement.content);
    });

    form?.addEventListener('submit', (e) => {
        e.preventDefault();

        const title = titleInput.value.trim();
        const content = contentInput.value.trim();

        if (title && content) {
            addAnnouncementToPage(title, content);

            // Save to localStorage
            storedAnnouncements.unshift({ title, content });
            localStorage.setItem('announcements', JSON.stringify(storedAnnouncements));

            form.reset();
        }
    });

    function addAnnouncementToPage(title, content) {
        const li = document.createElement('li');
        li.innerHTML = `
            <h3>${title}</h3>
            <p>${content}</p>
        `;
        announcementList.prepend(li);
    }
});
