<?php
require_once __DIR__ . '/includes/db.php';

$dbStatus = initializeDatabase();
$pdo = getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'create') {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');

        if ($name !== '' && $email !== '' && $phone !== '') {
            $stmt = $pdo->prepare('INSERT INTO contacts (name, email, phone) VALUES (:name, :email, :phone)');
            $stmt->execute([
                ':name' => $name,
                ':email' => $email,
                ':phone' => $phone,
            ]);
        }
    }

    if ($action === 'update') {
        $id = (int) ($_POST['id'] ?? 0);
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');

        if ($id > 0 && $name !== '' && $email !== '' && $phone !== '') {
            $stmt = $pdo->prepare('UPDATE contacts SET name = :name, email = :email, phone = :phone WHERE id = :id');
            $stmt->execute([
                ':name' => $name,
                ':email' => $email,
                ':phone' => $phone,
                ':id' => $id,
            ]);
        }
    }

    if ($action === 'delete') {
        $id = (int) ($_POST['id'] ?? 0);

        if ($id > 0) {
            $stmt = $pdo->prepare('DELETE FROM contacts WHERE id = :id');
            $stmt->execute([':id' => $id]);
        }
    }

    header('Location: index.php');
    exit;
}

$editContact = null;
if (isset($_GET['edit'])) {
    $editId = (int) $_GET['edit'];
    $stmt = $pdo->prepare('SELECT * FROM contacts WHERE id = :id');
    $stmt->execute([':id' => $editId]);
    $editContact = $stmt->fetch();
}

$contacts = $pdo->query('SELECT * FROM contacts ORDER BY id DESC')->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP CRUD Dashboard</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container">
        <header class="header">
            <h1>PHP CRUD Website</h1>
            <p>Database-ready contact manager with create, read, update, and delete actions.</p>
        </header>

        <div class="status-card">
            <?php echo htmlspecialchars($dbStatus); ?>
        </div>

        <div class="grid">
            <section class="card">
                <h2><?php echo $editContact ? 'Edit Contact' : 'Add Contact'; ?></h2>

                <form method="POST" action="index.php">
                    <?php if ($editContact): ?>
                        <input type="hidden" name="action" value="update">
                        <input type="hidden" name="id" value="<?php echo (int) $editContact['id']; ?>">
                    <?php else: ?>
                        <input type="hidden" name="action" value="create">
                    <?php endif; ?>

                    <label for="name">Name</label>
                    <input id="name" type="text" name="name" value="<?php echo htmlspecialchars($editContact['name'] ?? ''); ?>" required>

                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="<?php echo htmlspecialchars($editContact['email'] ?? ''); ?>" required>

                    <label for="phone">Phone</label>
                    <input id="phone" type="tel" name="phone" value="<?php echo htmlspecialchars($editContact['phone'] ?? ''); ?>" required>

                    <div class="actions">
                        <button class="btn-primary" type="submit"><?php echo $editContact ? 'Update Contact' : 'Save Contact'; ?></button>
                        <?php if ($editContact): ?>
                            <a href="index.php" class="btn btn-secondary" style="text-decoration: none; display: inline-block; text-align: center; padding: 12px 16px; border-radius: 10px; background: #eaf1ff; color: var(--primary-dark);">Cancel</a>
                        <?php endif; ?>
                    </div>
                </form>
            </section>

            <section class="card">
                <h2>Contacts</h2>

                <div class="table-wrap">
                    <?php if (count($contacts) > 0): ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($contacts as $contact): ?>
                                    <tr>
                                        <td><?php echo (int) $contact['id']; ?></td>
                                        <td><?php echo htmlspecialchars($contact['name']); ?></td>
                                        <td><?php echo htmlspecialchars($contact['email']); ?></td>
                                        <td><?php echo htmlspecialchars($contact['phone']); ?></td>
                                        <td>
                                            <div class="actions">
                                                <a href="index.php?edit=<?php echo (int) $contact['id']; ?>" class="btn btn-secondary" style="text-decoration: none; display: inline-block; text-align: center; padding: 10px 12px; border-radius: 10px; background: #eaf1ff; color: var(--primary-dark);">Edit</a>

                                                <form method="POST" action="index.php" style="display: inline; margin: 0;">
                                                    <input type="hidden" name="action" value="delete">
                                                    <input type="hidden" name="id" value="<?php echo (int) $contact['id']; ?>">
                                                    <button class="btn-danger" type="submit" onclick="return confirm('Delete this contact?');">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="empty-state">
                            No contacts found yet. Add your first contact using the form.
                        </div>
                    <?php endif; ?>
                </div>
            </section>
        </div>
    </div>
</body>
</html>
