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
