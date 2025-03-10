<?php
require_once(__DIR__ . '/../connect.config.php');
require_once(__DIR__ . '/../auth.config.php');
include '../control/user.control.php';

$locatorsGet = new UserDisplayController();
$limit = 10;

// Pagination setup
$page = isset($_GET['pageNum']) && is_numeric($_GET['pageNum']) && $_GET['pageNum'] > 0 ? (int) $_GET['pageNum'] : 1;
$offset = ($page - 1) * $limit;

// Get lease type (ongoing or expired)
$leaseType = isset($_GET['leaseType']) && $_GET['leaseType'] === 'expired' ? 'expired' : 'ongoing';
if ($leaseType === 'ongoing') {
    $totalRecords = $locatorsGet->getTotalOngoingLocators();
    $locators = $locatorsGet->getOngoingLocators($page, $limit);
} else {
    $totalRecords = $locatorsGet->getTotalExpiredLocators();
    $locators = $locatorsGet->getExpiredLocators($page, $limit);
}
$totalPages = ceil($totalRecords / $limit);
?>

<div class="container mt-5">
    <h2 class="text-center">Dashboard</h2>
    <div class="d-flex justify-content-between align-items-center mt-3">
        <input type="text" id="searchInput" placeholder="Search leases...">
        <button id="toggleLeaseType" class="btn btn-secondary">
            View <?php echo $leaseType === 'ongoing' ? 'Expired' : 'Ongoing'; ?> Leases
        </button>
    </div>
    <div class="tables-container mt-3">
        <table class="table text-center">
            <thead>
                <tr>
                    <th>Company Tenant</th>
                    <th>Account Officer</th>
                    <th>Address</th>
                    <th>Sec Registration</th>
                    <th>Lease Term</th>
                    <th>Start Term</th>
                    <th>End Term</th>
                    <th>Date Signed</th>
                    <th>Authorized Capital Stock</th>
                    <th>Subscribed Capital</th>
                    <th>Paid-Up Capital</th>
                    <th>Escalation Rate</th>
                    <th>Grace Period</th>
                    <th>Sub-lease</th>
                    <th>Advance Lease Payment</th>
                    <th>Security Deposit</th>
                    <th>Performance Security</th>
                </tr>
            </thead>
            <tbody id="leaseTable">
                <?php foreach ($locators as $locator): ?>
                    <tr>
                        <td><?php echo $locator['Tenant']; ?></td>
                        <td><?php echo $locator['AccountOfficer']; ?></td>
                        <td><?php echo $locator['Address']; ?></td>
                        <td><?php echo $locator['SecReg']; ?></td>
                        <td><?php echo $locator['LeaseTerm']; ?></td>
                        <td><?php echo !empty($locator['StartTerm']) ? date("M-d-Y", strtotime($locator['StartTerm'])) : 'N/A'; ?>
                        </td>
                        <td><?php echo !empty($locator['EndTerm']) ? date("M-d-Y", strtotime($locator['EndTerm'])) : 'N/A'; ?>
                        </td>
                        <td><?php echo !empty($locator['SignedDT']) ? date("M-d-Y", strtotime($locator['SignedDT'])) : 'N/A'; ?>
                        </td>
                        <td><?php echo $locator['CapitalStock']; ?></td>
                        <td><?php echo $locator['SubscribedCapital']; ?></td>
                        <td><?php echo $locator['PaidUpCapital']; ?></td>
                        <td><?php echo $locator['EscalationRate']; ?></td>
                        <td><?php echo $locator['GradePeriod']; ?></td>
                        <td><?php echo $locator['SubLeased']; ?></td>
                        <td><?php echo "ALP"//$locator['PaidUpCapital']; ?></td>
                        <td><?php echo "SD"//$locator['PaidUpCapital']; ?></td>
                        <td><?php echo "PS"//$locator['PaidUpCapital']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="text-center mt-2">
        <?php if ($page > 1): ?>
            <a href="main.view.php?page=dashboard&pageNum=<?php echo $page - 1; ?>&leaseType=<?php echo $leaseType; ?>"
                class="btn btn-primary">Previous</a>
        <?php endif; ?>
        <span>Page <?php echo $page; ?> of <?php echo $totalPages; ?></span>
        <?php if ($page < $totalPages): ?>
            <a href="main.view.php?page=dashboard&pageNum=<?php echo $page + 1; ?>&leaseType=<?php echo $leaseType; ?>"
                class="btn btn-primary">Next</a>
        <?php endif; ?>
    </div>
</div>

<script>
    document.getElementById("toggleLeaseType").addEventListener("click", function () {
        let currentLeaseType = "<?php echo $leaseType; ?>";
        let newLeaseType = currentLeaseType === "ongoing" ? "expired" : "ongoing";
        window.location.href = "main.view.php?page=dashboard&pageNum=1&leaseType=" + newLeaseType;
    });

    document.getElementById("searchInput").addEventListener("keyup", function () {
        let value = this.value.toLowerCase();
        document.querySelectorAll("#leaseTable tr").forEach(function (row) {
            row.style.display = row.textContent.toLowerCase().includes(value) ? "" : "none";
        });
    });
</script>