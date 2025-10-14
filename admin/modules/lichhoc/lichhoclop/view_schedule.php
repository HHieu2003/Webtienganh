<?php
// File: admin/modules/lichhoc/lichhoclop/view_schedule.php
if (!isset($lop_id)) die("Lỗi: Không tìm thấy thông tin lớp học.");
$schedules = $conn->query("SELECT * FROM lichhoc WHERE id_lop = '$lop_id' ORDER BY ngay_hoc ASC, gio_bat_dau ASC");
?>
<style>
    .schedule-timeline {
        position: relative;
        padding: 1rem 0;
        list-style: none;
    }
    .schedule-timeline::before {
        content: '';
        position: absolute;
        top: 0;
        left: 20px;
        height: 100%;
        width: 3px;
        background: #f0f3f5;
    }
    .timeline-item {
        position: relative;
        padding-left: 60px;
        margin-bottom: 2rem;
    }
    .timeline-icon {
        position: absolute;
        left: 0;
        top: 0;
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: var(--brand-color);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        border: 3px solid #fff;
        box-shadow: 0 0 0 3px var(--brand-color);
    }
    .timeline-content {
        background-color: #fff;
        padding: 1.5rem;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        border: 1px solid var(--border-color);
    }
    .timeline-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.5rem;
        padding-bottom: 0.75rem;
        margin-bottom: 0.75rem;
        border-bottom: 1px dashed var(--border-color);
    }
    .timeline-date { font-weight: 600; color: var(--dark-text); }
    .timeline-note {
        font-style: italic;
        color: #856404;
        background-color: #fff3cd;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.9rem;
    }
</style>

<div class="card animated-card">
     <div class="card-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h5 class="mb-0">Danh sách các buổi học</h5>
            <div>
                 <a href="modules/lichhoc/lichhoclop/export_schedule_for_class.php?lop_id=<?php echo htmlspecialchars($lop_id); ?>" class="btn btn-sm btn-info text-white"><i class="fa-solid fa-file-excel"></i> Excel</a>
                 <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addScheduleModal"><i class="fa-solid fa-plus"></i> Thêm buổi học</button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <?php if ($schedules->num_rows > 0): ?>
            <ul class="schedule-timeline">
                <?php 
                $index = 0;
                while ($schedule = $schedules->fetch_assoc()): 
                ?>
                <li class="timeline-item animated-item" style="animation-delay: <?php echo $index++ * 100; ?>ms;">
                    <div class="timeline-icon"><i class="fa-solid fa-calendar-check"></i></div>
                    <div class="timeline-content">
                        <div class="timeline-header">
                            <span class="timeline-date">Buổi học ngày: <?php echo date("d/m/Y", strtotime($schedule['ngay_hoc'])); ?></span>
                            <div class="btn-group">
                                <button class="btn btn-sm btn-outline-primary" onclick="openEditScheduleModal(<?php echo $schedule['id_lichhoc']; ?>)"><i class="fa-solid fa-pen"></i></button>
                                <button class="btn btn-sm btn-outline-danger" onclick="deleteSchedule(<?php echo $schedule['id_lichhoc']; ?>)"><i class="fa-solid fa-trash"></i></button>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <p class="mb-1 text-muted">Thời gian:</p>
                                <h6><i class="fa-solid fa-clock text-success me-2"></i><?php echo date("H:i", strtotime($schedule['gio_bat_dau'])) . ' - ' . date("H:i", strtotime($schedule['gio_ket_thuc'])); ?></h6>
                            </div>
                            <div class="col-md-6">
                                 <p class="mb-1 text-muted">Phòng học/Link:</p>
                                 <h6><i class="fa-solid fa-map-marker-alt text-success me-2"></i><?php echo htmlspecialchars($schedule['phong_hoc']); ?></h6>
                            </div>
                        </div>
                        <?php if(!empty($schedule['ghi_chu'])): ?>
                            <div class="timeline-note mt-3">
                                <strong>Ghi chú:</strong> <?php echo htmlspecialchars($schedule['ghi_chu']); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <div class="alert alert-light text-center">Lớp này chưa có lịch học.</div>
        <?php endif; ?>
    </div>
</div>