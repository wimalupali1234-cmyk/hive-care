document.addEventListener('DOMContentLoaded', () => {
    const sessions = [
        { id: 1, session_code: 'S001', date: '2025-10-22', time: '10:00', mode: 'Online', status: 'Scheduled' },
        { id: 2, session_code: 'S002', date: '2025-10-23', time: '14:00', mode: 'Offline', status: 'Scheduled' },
        { id: 3, session_code: 'S003', date: '2025-10-24', time: '09:00', mode: 'Online', status: 'Completed' },
    ];

    const sessionList = document.getElementById('session-list');

    sessions.forEach(session => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${session.session_code}</td>
            <td>${session.date}</td>
            <td>${session.time}</td>
            <td>${session.mode}</td>
            <td>${session.status}</td>
            <td>
                <a href="index.php?action=counsellorSaveNotes&sessionId=${session.id}">Add/Edit Notes</a> |
                <a href="index.php?action=counsellorUpdateStatus&sessionId=${session.id}&status=Completed">Mark Completed</a> |
                <a href="index.php?action=counsellorUpdateStatus&sessionId=${session.id}&status=Missed">Mark Missed</a> |
                <a href="index.php?action=counsellorUpdateStatus&sessionId=${session.id}&status=Rescheduled">Reschedule</a>
            </td>
        `;
        sessionList.appendChild(row);
    });
});
