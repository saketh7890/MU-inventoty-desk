function func() {
    const emailElement = document.getElementById("username");
    const passElement = document.getElementById("pass");

    if (emailElement && passElement) {
        const email = emailElement.value;
        const pass = passElement.value;

        if ((email === 'Thala777@gmail.com' && pass === '123456') || (email === 'Faculty@gmail.com' && pass === '123')) {
            setTimeout(() => {
                window.location.assign("Homepage.php");
            }, 10);
        } else {
            document.getElementById("para").innerHTML = "Invalid username or password";
            alert("Invalid username or password");
        }
    } else {
        console.error("Username or password input element not found.");
    }
}

function func2() {
    window.location.assign("login.php");
}

function func3() {
    window.location.assign("Layout.php");
}

document.addEventListener("DOMContentLoaded", () => {
    const seating = document.querySelector(".seating");
    const blocks = document.querySelectorAll(".seating > .block");
    const blockSelect = document.getElementById("Block");

    // Function to add click listeners to computers
    function addClickListeners() {
        const computers = document.querySelectorAll(".rows .computer:not(.notworking)");

        computers.forEach(computer => {
            computer.removeEventListener("click", handleClick); // Ensure no duplicate listeners
            computer.addEventListener("click", handleClick);
        });
    }

    // Handle computer click event
// Function to handle seat selection/deselection
function handleClick() {
    this.classList.toggle("selected");

    // Log the computer data
    const blockElement = this.closest(".block");
    const blockClass = Array.from(blockElement.classList).find(cls => cls.startsWith('block-'));
    const blockName = blockClass.split('-')[1].toUpperCase();
    const rowIndex = Array.from(this.parentNode.parentNode.children).indexOf(this.parentNode);
    const computerIndex = Array.from(this.parentNode.children).indexOf(this);

    console.log(`Block: ${blockName}, Row: ${rowIndex + 1}, Computer: ${computerIndex + 1}`);

    // Update the table cell (computer) based on the indices
    updateTableCell(blockName, rowIndex, computerIndex);

    // Send seat information to the server
    sendDataToServer(blockName, rowIndex + 1, computerIndex + 1);
}

// Function to send seat information to the server
function sendDataToServer(block, row, computer) {
    const data = {
        block: block,
        row: row,
        computer: computer
    };

    fetch('update_database.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        console.log('Response from server:', data);
        // Handle response from server if needed
    })
    .catch(error => {
        console.error('Error sending data to server:', error);
        // Handle error
    });
}

    // Function to display the selected block
    function displaySelectedBlock() {
        const selectedBlock = blockSelect.value.toUpperCase();

        blocks.forEach(block => {
            if (block.classList.contains(`block-${selectedBlock}`)) {
                block.style.display = "block";
            } else {
                block.style.display = "none";
            }
        });

        addClickListeners();
    }

    blockSelect.addEventListener("change", displaySelectedBlock);
    displaySelectedBlock();

    // Event listener for the submit button
    const submitButton = document.getElementById("btn");
    submitButton.addEventListener("click", () => {
        // Get the selected date
        const selectedDate = document.querySelector('input[type="date"]').value;

        // Get the selected time slot
        const selectedSlot = document.querySelector('.slot.selected');
        const selectedTimeSlot = selectedSlot ? selectedSlot.textContent : 'No time slot selected';

        // Log the selected date and time
        console.log(`Selected Date: ${selectedDate}, Selected Time Slot: ${selectedTimeSlot}`);

        // Get all selected seats
        const selectedSeats = document.querySelectorAll(".computer.selected");

        // Make selected seats unavailable
        selectedSeats.forEach(seat => {
            seat.classList.remove("selected");
            seat.classList.add("Booked"); // Change the class to Booked
        });

        // Save selected seats
        saveSelectedSeats();
    });

    function updateLayout() {
        const seats = document.querySelectorAll('.computer');

        seats.forEach(seat => {
            seat.addEventListener('click', function() {
                if (!seat.classList.contains('selected')) {
                    seat.classList.toggle('notworking');
                }
            });
        });
    }

    function addClickListeners() {
        const seats = document.querySelectorAll('.computer:not(.notworking)');

        seats.forEach(seat => {
            seat.removeEventListener("click", handleClick); // Remove existing listeners
            seat.addEventListener("click", handleClick);
        });
    }

    function saveSelectedSeats() {
        const selectedSeats = document.querySelectorAll(".computer.selected");
        const selectedSeatIndices = [];

        selectedSeats.forEach(seat => {
            const rowIndex = Array.from(seat.parentNode.parentNode.children).indexOf(seat.parentNode);
            const computerIndex = Array.from(seat.parentNode.children).indexOf(seat);
            selectedSeatIndices.push({ rowIndex, computerIndex });
        });

        localStorage.setItem("selectedSeats", JSON.stringify(selectedSeatIndices));
    }

    function loadSelectedSeats() {
        const selectedSeatIndices = JSON.parse(localStorage.getItem("selectedSeats"));

        if (selectedSeatIndices) {
            selectedSeatIndices.forEach(({ rowIndex, computerIndex }) => {
                const block = blocks[rowIndex];
                const seat = block.querySelector(`.rows:nth-child(${rowIndex + 1}) .computer:nth-child(${computerIndex + 1})`);
                seat.classList.add("selected");
            });
        }
    }

    loadSelectedSeats();
});

document.addEventListener('DOMContentLoaded', function () {
    const slots = document.querySelectorAll('.slot');

    slots.forEach(slot => {
        slot.addEventListener('click', function () {
            // Remove selected class from all slots
            slots.forEach(s => s.classList.remove('selected'));
            // Add selected class to the clicked slot
            this.classList.add('selected');
        });
    });
});

function func4() {
    const seats = document.querySelectorAll('.computer:not(.notworking)');

    seats.forEach(seat => {
        seat.classList.add('Booked');
    });
}

// Event listener for the SelectAll button
const selectAllButton = document.getElementById("selectall");
selectAllButton.addEventListener("click", () => {
    func4();
});
