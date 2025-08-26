
    <div class="container my-3">
        <h1 class="text-center title-color">Dashboard</h1>
        <div class="row">
            <!-- Total Students Card -->
            <div class="col-md-4 ">
                <div class="card text-white bg-primary mb-3 boder-shadow">
                    <div class="card-body  ">
                        <h5 class="card-title ">
                            <i class="fa-solid fa-users"></i>
                            Tổng số học viên
                    </h5>
                        <p class="card-text display-6">
                            <?php
                            // Database connection
                            include('../config/config.php');
                            
                            // Query to get the total number of students
                            $sql_students = "SELECT COUNT(*) AS total_students FROM hocvien";
                            $result_students = mysqli_query($conn, $sql_students);
                            $total_students = mysqli_fetch_assoc($result_students)['total_students'] ?? 0;
                            
                            echo $total_students;
                            ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Total Courses Card -->
            <div class="col-md-4">
                <div class="card text-white bg-success mb-3 boder-shadow">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fa-solid fa-graduation-cap"></i> Tổng khóa học</h5>
                        <p class="card-text display-6">
                            <?php
                            // Query to get the total number of courses
                            $sql_courses = "SELECT COUNT(*) AS total_courses FROM khoahoc";
                            $result_courses = mysqli_query($conn, $sql_courses);
                            $total_courses = mysqli_fetch_assoc($result_courses)['total_courses'] ?? 0;
                            
                            echo $total_courses;
                            ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Registered Courses Card -->
            <div class="col-md-4">
                <div class="card text-white bg-danger mb-3 boder-shadow">
                    <div class="card-body">
                        <h5 class="card-title"> <i class="fa-solid fa-circle-dollar-to-slot"></i> Khóa học đã bán</h5>
                        <p class="card-text display-6">
                            <?php
                            // Query to get the number of course registrations
                            $sql_registrations = "SELECT COUNT(*) AS total_registrations FROM dangkykhoahoc";
                            $result_registrations = mysqli_query($conn, $sql_registrations);
                            $total_registrations = mysqli_fetch_assoc($result_registrations)['total_registrations'] ?? 0;
                            
                            echo $total_registrations;
                            ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

          <!-- Course List with Registration Count -->
          <div class="my-5">
    <h2 class="mb-4">Danh sách các khóa học, số lượng đăng ký và điểm đánh giá</h2>
    <table class="table table-striped table-bordered">
        <thead class="table-dark"s>
            <tr>
                <th>Tên khóa học</th>
                <th>Số lượng đăng ký</th>
                <th>Điểm đánh giá trung bình</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Query to get all courses, their registration counts, and average ratings
            $sql_course_list = "
                SELECT k.ten_khoahoc, 
                       COUNT(d.id_dangky) AS total_registrations,
                       COALESCE(AVG(r.diem_danhgia), 0) AS avg_rating
                FROM khoahoc k
                LEFT JOIN dangkykhoahoc d ON k.id_khoahoc = d.id_khoahoc
                LEFT JOIN danhgiakhoahoc r ON k.id_khoahoc = r.id_khoahoc
                GROUP BY k.id_khoahoc
                ORDER BY total_registrations DESC
            ";
            $result_course_list = mysqli_query($conn, $sql_course_list);

            // Display courses, registration counts, and average ratings
            while ($row = mysqli_fetch_assoc($result_course_list)) {
                echo "<tr>
                        <td>{$row['ten_khoahoc']}</td>
                        <td >{$row['total_registrations']}</td>
                        <td>" . number_format($row['avg_rating'], 2) . "</td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>
</div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

