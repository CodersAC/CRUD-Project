<?php
require_once(__DIR__ . '/../connect.config.php');
require_once(__DIR__ . '/../auth.config.php');


include '../control/user.control.php';
$userGet = new UserDisplayController();

// Pagination Settings
$limit = 10; // Number of records per page
$page = isset($_GET['p']) && is_numeric($_GET['p']) && $_GET['p'] > 0 ? (int) $_GET['p'] : 1;
$totalRows = $userGet->getTotalUsers();
$totalPages = ceil($totalRows / $limit);

// Fetch paginated data
$users = $userGet->showAllUsersPage($page, $limit);

?>

<div class="container mt-5">
    <h2 class="text-center">Manage Users</h2>
    <div class="mt-3 search-edit-container">
        <!-- Search Bar -->
        <input type="text" id="searchInput" placeholder="Search table...">
    </div>
    <div class="table-container mt-3">
        <!-- Users Table -->
        <table class="table text-center">
            <thead>
                <tr>
                    <th>UserID</th>
                    <th>Complete Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo $user['UserID']; ?></td>
                        <td><?php echo $user['CompleteName']; ?></td>
                        <td>
                            <!-- Edit Button -->
                            <a href="../route.config.php?action=edit&editId= <?php echo $user['PK']; ?>"
                                class="btn btn-warning btn-sm"> Edit</a>
                            <!-- Delete Button -->
                            <a href="../route.config.php?action=delete&deleteId= <?php echo $user['PK']; ?>"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Are you sure you want to delete this user? <?php echo $user['UserID']; ?>')">
                                Delete
                            </a>
                            <!-- Reset Default Pass -->
                            <a href="../route.config.php?action=reset&resetId= <?php echo $user['PK']; ?>"
                                class="btn btn-success btn-sm"
                                onclick="return confirm('Are you sure you want to reset the password of this user? <?php echo $user['UserID']; ?>')">
                                Reset
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <!-- Pagination Controls -->
    <div class="text-center mt-2">
        <?php if ($page > 1): ?>
            <a href="main.view.php?page=dashboard&p=<?php echo $page - 1; ?>" class="btn btn-primary">Previous</a>
        <?php endif; ?>

        <span>Page <?php echo $page; ?> of <?php echo $totalPages; ?></span>

        <?php if ($page < $totalPages): ?>
            <a href="main.view.php?page=dashboard&p=<?php echo $page + 1; ?>" class="btn btn-primary">Next</a>
        <?php endif; ?>
    </div>
</div>

<script>
    $(document).ready(function () {
        $("#searchInput").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            $("tbody tr").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });
    });
</script>