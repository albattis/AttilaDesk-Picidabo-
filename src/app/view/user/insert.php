
<!-- Új felhasználó hozzáadása gomb -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addUserModal">
    Új Felhasználó Hozzáadása
</button>

<!-- Modál szerkezete -->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Új Felhasználó Hozzáadása</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addUserForm" action="index.php?controller=user&action=addUser" method="POST">
                    <div class="form-group">
                        <label for="username">Felhasználónév:</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Jelszó:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="role">Szerepkör:</label>
                        <select class="form-control" id="role" name="role" required>
                            <option value="employee">Employee</option>
                            <option value="boss">Boss</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Felhasználó Hozzáadása</button>
                </form>
            </div>
        </div>
    </div>
</div>




<script>
    document.getElementById('addUserForm').addEventListener('submit', async function(event) {
        event.preventDefault(); // Megakadályozzuk az alapértelmezett form elküldést

        let formData = new FormData(this);
        let data = Object.fromEntries(formData.entries());

        try {
            let response = await fetch(this.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            });

            let result = await response.json();
            if (result.success) {
                // Sikeres hozzáadás esetén zárjuk be a modált és frissítsük az adatokat
                $('#addUserModal').modal('hide');
                alert('Új felhasználó sikeresen hozzáadva!');
                // Frissítsük a felhasználói listát vagy végezzük el a szükséges műveleteket
            } else {
                alert('Hiba történt: ' + result.message);
            }
        } catch (error) {
            console.error('Error:', error);
        }
    });
</script>

