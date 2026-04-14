<?php
// ===========================================
// استلام البيانات من النموذج
// ===========================================
$amount = floatval($_POST["المبلغ"] ?? 0);
$debt = floatval($_POST["ديون"] ?? 0);
$amount_after_debt = $amount - $debt;

// الورثة المباشرون
$sons = intval($_POST["أبناء"] ?? 0);
$daughters = intval($_POST["بنات"] ?? 0);
$father = intval($_POST["أب"] ?? 0);
$mother = intval($_POST["أم"] ?? 0);
$husband = intval($_POST["زوج"] ?? 0);
$wives = intval($_POST["زوجات"] ?? 0);

// الأحفاد
$grandsons = intval($_POST["أبناء_الأبناء"] ?? 0);
$granddaughters_from_daughter = intval($_POST["بنات_البنات"] ?? 0);

// وقت الوفاة
$death_time_grandson = $_POST["وفاة_ابناء_الابناء"] ?? "بعد";
$death_time_granddaughter = $_POST["وفاة_بنات_البنات"] ?? "بعد";

// مصفوفات النتائج
$shares_grandfather = []; // ميراث الجد
$shares_father = []; // ميراث الابن (أبو الأبناء)
$labels_grandfather = [];
$data_grandfather = [];
$labels_father = [];
$data_father = [];

$total_distributed = 0;

// ===========================================
// حساب ميراث الجد (الخطوة الأولى)
// ===========================================
$remaining = $amount_after_debt;

/* الزوج */
if($husband == 1){
    if(($sons + $daughters + $grandsons) > 0){
        $share = $amount_after_debt * 0.25;
        $shares_grandfather["الزوج"] = $share;
    } else {
        $share = $amount_after_debt * 0.5;
        $shares_grandfather["الزوج"] = $share;
    }
    $remaining -= $share;
}

/* الزوجات */
if($wives > 0){
    if(($sons + $daughters + $grandsons) > 0){
        $total_share = $amount_after_debt * 0.125;
    } else {
        $total_share = $amount_after_debt * 0.25;
    }
    
    $share_per_wife = $total_share / $wives;
    for($i = 1; $i <= $wives; $i++){
        $shares_grandfather["الزوجة $i"] = $share_per_wife;
    }
    $shares_grandfather["الزوجات (مجموع)"] = $total_share;
    $remaining -= $total_share;
}

/* الأم */
if($mother == 1){
    if(($sons + $daughters + $grandsons) > 0){
        $share = $amount_after_debt * (1/6);
    } else {
        $share = $amount_after_debt * (1/3);
    }
    $shares_grandfather["الأم"] = $share;
    $remaining -= $share;
}

/* الأب */
if($father == 1){
    if($sons > 0){
        $share = $amount_after_debt * (1/6);
        $shares_grandfather["الأب"] = $share;
        $remaining -= $share;
    }
    // إذا لم يوجد أبناء، سيتم حساب الأب لاحقاً في التعصيب
}

// ===========================================
// توزيع الباقي (التعصيب) على أبناء وبنات الجد
// ===========================================
if($remaining > 0.001 && $sons + $daughters > 0){
    $total_parts = ($sons * 2) + $daughters;
    $value_per_part = $remaining / $total_parts;
    
    for($i = 1; $i <= $sons; $i++){
        $shares_grandfather["الابن $i"] = $value_per_part * 2;
    }
    for($i = 1; $i <= $daughters; $i++){
        $shares_grandfather["البنت $i"] = $value_per_part;
    }
    
    // تحديد أي ابن هو أبو الأبناء (نفترض أنه الابن الأول)
    $father_share_from_grandfather = $value_per_part * 2; // نصيب الابن (أبو الأبناء)
}

// ===========================================
// تجهيز بيانات الرسم البياني للجد
// ===========================================
foreach($shares_grandfather as $key => $value){
    if($key != "الزوجات (مجموع)" && $value > 0){
        $labels_grandfather[] = $key;
        $data_grandfather[] = $value;
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>نتيجة حساب الميراث - القانون الجزائري</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Tahoma', sans-serif;
            background: linear-gradient(135deg, #0d3d4e, #1a6b7a);
            padding: 40px 20px;
            margin: 0;
            color: #333;
        }
        .container {
            max-width: 1200px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            border: 2px solid #d4af37;
        }
        h2 {
            color: #0d3d4e;
            border-bottom: 3px solid #d4af37;
            padding-bottom: 10px;
            margin-top: 30px;
            font-size: 28px;
        }
        h2:first-of-type {
            margin-top: 0;
        }
        .chart-container {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            margin: 40px 0;
            justify-content: center;
        }
        .chart-box {
            flex: 1 1 400px;
            background: #f9f9f9;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        canvas {
            max-height: 400px;
            width: 100% !important;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            box-shadow: 0 5px 10px rgba(0,0,0,0.1);
        }
        th {
            background: #0d3d4e;
            color: white;
            padding: 15px;
            font-size: 16px;
        }
        td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }
        tr:nth-child(even) {
            background: #f9f9f9;
        }
        .total-row {
            background: #e8f4f8;
            font-weight: bold;
        }
        .warning {
            background: #f8d7da;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            border-right: 5px solid #dc3545;
            font-size: 16px;
        }
        .note {
            background: #fff3cd;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            border-right: 5px solid #ffc107;
        }
        .btn {
            display: inline-block;
            padding: 12px 30px;
            background: #0d3d4e;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            transition: 0.3s;
            margin: 10px;
        }
        .btn:hover {
            background: #1a6b7a;
            transform: scale(1.05);
        }
        .father-box {
            background: #e7f3ff;
            padding: 15px;
            border-radius: 10px;
            border-right: 5px solid #0d3d4e;
            margin: 20px 0;
        }
        .chart-title {
            text-align: center;
            color: #0d3d4e;
            margin-bottom: 20px;
            font-size: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>📊 نتيجة توزيع ميراث الجد</h2>
        
        <!-- تنبيه خاص بأبناء الأبناء -->
        <?php if($grandsons > 0 && $death_time_grandson == "بعد"): ?>
        <div class="warning">
            <strong style="font-size: 18px;">⚠️ تنبيه هام جداً:</strong>
            <p style="font-size: 16px; margin-top: 10px;">
                <strong>أبناء الأبناء (عدد: <?php echo $grandsons; ?>)</strong> لا يرثون من الجد مباشرة،<br>
                لأن أباهم (الابن) توفي <strong>بعد</strong> الجد.
            </p>
            <p style="font-size: 15px; margin-top: 10px;">
                ✅ الابن كان حياً وقت وفاة الجد وورث منه <strong><?php echo number_format($father_share_from_grandfather ?? 0, 2); ?> دج</strong>.<br>
                ✅ بعد وفاة الابن، سيرث أبناؤه (أبناء الأبناء) من <strong>تركته هو</strong> (التي تشمل هذا المبلغ).
            </p>
        </div>
        <?php endif; ?>
        
        <!-- الرسم البياني لميراث الجد -->
        <?php if(!empty($labels_grandfather)): ?>
        <div class="chart-container">
            <div class="chart-box">
                <div class="chart-title">📈 توزيع ميراث الجد</div>
                <canvas id="grandfatherChart"></canvas>
            </div>
        </div>
        <?php endif; ?>
        
        <!-- جدول ميراث الجد -->
        <table>
            <tr>
                <th>الوارث من الجد</th>
                <th>النصيب (دج)</th>
                <th>النسبة</th>
                <th>ملاحظات</th>
            </tr>
            <?php
            $total_grandfather = 0;
            foreach($shares_grandfather as $heir => $value):
                if($heir != "الزوجات (مجموع)" && $value > 0):
                    $total_grandfather += $value;
            ?>
            <tr>
                <td><?php echo $heir; ?></td>
                <td><strong><?php echo number_format($value, 2); ?></strong></td>
                <td><?php echo number_format(($value / $amount_after_debt) * 100, 2); ?>%</td>
                <td>
                    <?php 
                    if(strpos($heir, "الابن") !== false){
                        echo "يرث بالتعصيب مع البنات";
                    } elseif(strpos($heir, "البنت") !== false){
                        echo "ترث مع الذكور بالتعصيب";
                    } elseif(strpos($heir, "الزوجة") !== false){
                        echo "نصيبها من الثمن/الربع";
                    } else {
                        echo "نصيب شرعي حسب الفرض";
                    }
                    ?>
                </td>
            </tr>
            <?php 
                endif;
            endforeach; 
            ?>
            <tr class="total-row">
                <td colspan="2"><strong>مجموع ميراث الجد</strong></td>
                <td><strong><?php echo number_format($total_grandfather, 2); ?> دج</strong></td>
                <td><strong>100%</strong></td>
            </tr>
        </table>
        
        <!-- تفصيل ميراث الابن (أبو الأبناء) -->
        <?php if($grandsons > 0 && $death_time_grandson == "بعد"): ?>
        <h2>📋 ميراث الابن (أبو الأبناء) - بعد وفاته</h2>
        
        <div class="father-box">
            <p><strong>💰 نصيب الابن من الجد:</strong> <?php echo number_format($father_share_from_grandfather ?? 0, 2); ?> دج</p>
            <p><strong>➕ أمواله الخاصة (افتراضياً):</strong> 300,000 دج (يمكنك تعديل هذا الرقم)</p>
            <p><strong>📦 إجمالي تركة الابن:</strong> <?php echo number_format(($father_share_from_grandfather ?? 0) + 300000, 2); ?> دج</p>
        </div>
        
        <?php
        // حساب ميراث الابن (افتراضياً)
        $father_total = ($father_share_from_grandfather ?? 0) + 300000; // نضيف أمواله الخاصة
        
        // ورثة الابن (افتراضياً: زوجة + 5 أبناء)
        $wife_share = $father_total * 0.125; // الثمن
        $remaining_father = $father_total - $wife_share;
        
        // الأبناء الخمسة يأخذون الباقي
        $sons_share = $remaining_father;
        $each_son_share = $sons_share / $grandsons;
        
        // تجهيز بيانات الرسم البياني للابن
        $labels_father = [];
        $data_father = [];
        
        for($i = 1; $i <= $grandsons; $i++){
            $labels_father[] = "ابن الابن $i";
            $data_father[] = $each_son_share;
        }
        $labels_father[] = "زوجة الابن";
        $data_father[] = $wife_share;
        ?>
        
        <!-- الرسم البياني لميراث الابن -->
        <div class="chart-container">
            <div class="chart-box">
                <div class="chart-title">📈 توزيع ميراث الابن (أبو الأبناء)</div>
                <canvas id="fatherChart"></canvas>
            </div>
        </div>
        
        <table>
            <tr>
                <th>الوارث من الابن</th>
                <th>النصيب (دج)</th>
                <th>النسبة</th>
                <th>التفاصيل</th>
            </tr>
            <?php
            for($i = 1; $i <= $grandsons; $i++){
                echo "<tr>";
                echo "<td>ابن الابن $i</td>";
                echo "<td><strong>" . number_format($each_son_share, 2) . " دج</strong></td>";
                echo "<td>" . number_format(($each_son_share / $father_total) * 100, 2) . "%</td>";
                echo "<td>نصيبه من ميراث أبيه (بعد نصيب الزوجة)</td>";
                echo "</tr>";
            }
            
            echo "<tr>";
            echo "<td>زوجة الابن (أمهم)</td>";
            echo "<td><strong>" . number_format($wife_share, 2) . " دج</strong></td>";
            echo "<td>" . number_format(($wife_share / $father_total) * 100, 2) . "%</td>";
            echo "<td>الزوجة ترث الثمن (1/8) لوجود الأبناء</td>";
            echo "</tr>";
            ?>
            <tr class="total-row">
                <td colspan="2"><strong>مجموع ميراث الابن</strong></td>
                <td><strong><?php echo number_format($father_total, 2); ?> دج</strong></td>
                <td><strong>100%</strong></td>
            </tr>
        </table>
        
        <div class="note">
            <strong>📌 ملاحظة مهمة:</strong>
            <ul style="margin-top: 10px;">
                <li>هذا التوزيع افتراضي بناءً على أن ورثة الابن هم: <strong>زوجته + أبناؤه الخمسة</strong> فقط.</li>
                <li>إذا كان للابن <strong>والدان أحياء</strong> أو <strong>بنات</strong>، يتغير التوزيع.</li>
                <li>يمكنك تعديل <strong>أموال الابن الخاصة</strong> في الكود حسب الحالة الحقيقية.</li>
            </ul>
        </div>
        <?php endif; ?>
        
        <!-- رسالة إذا كان أبناء الأبناء توفوا قبل الجد -->
        <?php if($grandsons > 0 && $death_time_grandson == "قبل"): ?>
        <div class="note">
            <strong>📌 الوصية الواجبة:</strong>
            <p>أبناء الأبناء (<strong><?php echo $grandsons; ?></strong>) يرثون من الجد مباشرة <strong>بالوصية الواجبة</strong> لأن أباهم توفي قبل الجد.</p>
        </div>
        <?php endif; ?>
        
        <div style="text-align: center; margin-top: 40px;">
            <a href="javascript:history.back()" class="btn">🔙 العودة للإدخال</a>
            <a href="index.php" class="btn">🏠 الصفحة الرئيسية</a>
        </div>
        
        <div style="margin-top: 30px; font-size: 14px; color: #666; text-align: center; border-top: 1px solid #ddd; padding-top: 20px;">
            <p>⚠️ هذا البرنامج يقدم حسابات استرشادية حسب القانون الجزائري. للفتوى الشرعية الدقيقة، راجع عالم فقه موثوق.</p>
        </div>
    </div>
    
    <script>
        // رسم بياني لميراث الجد
        <?php if(!empty($labels_grandfather)): ?>
        new Chart(document.getElementById('grandfatherChart'), {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($labels_grandfather); ?>,
                datasets: [{
                    data: <?php echo json_encode($data_grandfather); ?>,
                    backgroundColor: [
                        '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF',
                        '#FF9F40', '#FF6384', '#C9CBCF', '#4BC0C0', '#36A2EB',
                        '#FFB6C1', '#87CEEB', '#FFD700', '#98FB98', '#DDA0DD',
                        '#FFA07A', '#20B2AA', '#778899', '#B0C4DE', '#E6E6FA'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            font: {
                                size: 12,
                                family: 'Tahoma'
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                let value = context.raw || 0;
                                let total = context.dataset.data.reduce((a, b) => a + b, 0);
                                let percentage = ((value / total) * 100).toFixed(2);
                                return label + ': ' + value.toFixed(2) + ' دج (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });
        <?php endif; ?>
        
        // رسم بياني لميراث الابن
        <?php if(!empty($labels_father)): ?>
        new Chart(document.getElementById('fatherChart'), {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($labels_father); ?>,
                datasets: [{
                    data: <?php echo json_encode($data_father); ?>,
                    backgroundColor: [
                        '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF',
                        '#FF9F40', '#FF6384', '#C9CBCF', '#4BC0C0', '#36A2EB'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            font: {
                                size: 12,
                                family: 'Tahoma'
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                let value = context.raw || 0;
                                let total = context.dataset.data.reduce((a, b) => a + b, 0);
                                let percentage = ((value / total) * 100).toFixed(2);
                                return label + ': ' + value.toFixed(2) + ' دج (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });
        <?php endif; ?>
    </script>
            <!-- =========================================== -->
        <!-- أزرار التنقل (كما هي)                       -->
        <!-- =========================================== -->
        <div style="text-align: center; margin-top: 40px;">
            <a href="javascript:history.back()" class="btn">🔙 العودة للإدخال</a>
            <a href="index.php" class="btn">🏠 الصفحة الرئيسية</a>
        </div>

        <!-- =========================================== -->
        <!-- شرح النتائج والقواعد المستخدمة (إضافة جديدة) -->
        <!-- =========================================== -->
        <div style="margin-top: 50px; padding: 25px; background: #f0f7fa; border-radius: 15px; border: 1px solid #b8d9e5;">
            <h2 style="color: #0d3d4e; border-bottom: 2px solid #d4af37; padding-bottom: 10px;">📜 شرح النتائج والقواعد المعتمدة في الحساب</h2>
            
            <!-- شرح النتائج الحالية -->
            <div style="background: white; padding: 20px; border-radius: 10px; margin-bottom: 25px;">
                <h3 style="color: #0d3d4e; margin-top: 0;">📊 تحليل النتائج أعلاه</h3>
                <?php
                // توليد شرح مخصص حسب الحالة
                echo "<ul style='line-height: 1.8;'>";
                
                if($husband == 1) {
                    if(($sons + $daughters + $grandsons) > 0) {
                        echo "<li><strong>الزوج:</strong> أخذ الربع (1/4) لوجود فرع وارث (الأبناء) - تطبيقاً لسورة النساء 12.</li>";
                    } else {
                        echo "<li><strong>الزوج:</strong> أخذ النصف (1/2) لعدم وجود فرع وارث - تطبيقاً لسورة النساء 12.</li>";
                    }
                }
                
                if($wives > 0) {
                    if(($sons + $daughters + $grandsons) > 0) {
                        echo "<li><strong>الزوجات:</strong> أخذن الثمن (1/8) مقسم بينهن بالتساوي لوجود فرع وارث - تطبيقاً لسورة النساء 12.</li>";
                    } else {
                        echo "<li><strong>الزوجات:</strong> أخذن الربع (1/4) مقسم بينهن بالتساوي لعدم وجود فرع وارث - تطبيقاً لسورة النساء 12.</li>";
                    }
                }
                
                if($mother == 1) {
                    if(($sons + $daughters + $grandsons) > 0) {
                        echo "<li><strong>الأم:</strong> أخذت السدس (1/6) لوجود فرع وارث - تطبيقاً لسورة النساء 11.</li>";
                    } else {
                        echo "<li><strong>الأم:</strong> أخذت الثلث (1/3) لعدم وجود فرع وارث - تطبيقاً لسورة النساء 11.</li>";
                    }
                }
                
                if($father == 1 && $sons > 0) {
                    echo "<li><strong>الأب:</strong> أخذ السدس (1/6) لوجود الأبناء - تطبيقاً لسورة النساء 11.</li>";
                }
                
                if($sons + $daughters > 0) {
                    echo "<li><strong>الأبناء والبنات:</strong> ورثوا الباقي بالتعصيب بنسبة 2:1 للذكر مثل حظ الأنثيين - تطبيقاً لسورة النساء 11.</li>";
                }
                
                if($grandsons > 0) {
                    if($death_time_grandson == "بعد") {
                        echo "<li><strong>أبناء الأبناء:</strong> لم يرثوا من الجد مباشرة لأن أباهم توفي بعد الجد، وسترث من تركة أبيهم (التي تشمل نصيبه من الجد).</li>";
                    } else {
                        echo "<li><strong>أبناء الأبناء:</strong> يرثون من الجد بالوصية الواجبة لأن أباهم توفي قبل الجد - تطبيقاً للمادة 133 من قانون الأسرة الجزائري.</li>";
                    }
                }
                
                echo "</ul>";
                ?>
            </div>
            
            <!-- القواعد العامة (ثلاثة أعمدة) -->
            <div style="display: flex; flex-wrap: wrap; gap: 25px; margin-top: 20px;">
                <!-- العمود الأول: القرآن الكريم -->
                <div style="flex: 1 1 300px; background: white; padding: 20px; border-radius: 12px; box-shadow: 0 3px 10px rgba(0,0,0,0.05);">
                    <h3 style="color: #0d3d4e; border-right: 4px solid #d4af37; padding-right: 10px;">📖 الآيات القرآنية</h3>
                    <ul style="list-style: none; padding-right: 0; line-height: 2;">
                        <li style="margin-bottom: 15px; padding-bottom: 10px; border-bottom: 1px dashed #eee;">
                            <strong>🔸 سورة النساء 11:</strong>
                            <p style="margin: 5px 0 0 20px; font-size: 14px;">"يُوصِيكُمُ اللَّهُ فِي أَوْلَادِكُمْ ۖ لِلذَّكَرِ مِثْلُ حَظِّ الْأُنثَيَيْنِ..."</p>
                            <p style="margin: 5px 0 0 20px; font-size: 13px; color: #555;">➜ تطبق في توزيع التعصيب (الابن : البنت 2:1)</p>
                        </li>
                        <li style="margin-bottom: 15px; padding-bottom: 10px; border-bottom: 1px dashed #eee;">
                            <strong>🔸 سورة النساء 11:</strong>
                            <p style="margin: 5px 0 0 20px; font-size: 14px;">"وَلِأَبَوَيْهِ لِكُلِّ وَاحِدٍ مِّنْهُمَا السُّدُسُ مِمَّا تَرَكَ إِن كَانَ لَهُ وَلَدٌ..."</p>
                            <p style="margin: 5px 0 0 20px; font-size: 13px; color: #555;">➜ تطبق في نصيب الأب (1/6 عند وجود الأبناء)</p>
                        </li>
                        <li style="margin-bottom: 15px; padding-bottom: 10px; border-bottom: 1px dashed #eee;">
                            <strong>🔸 سورة النساء 11:</strong>
                            <p style="margin: 5px 0 0 20px; font-size: 14px;">"فَإِن لَّمْ يَكُن لَّهُ وَلَدٌ وَوَرِثَهُ أَبَوَاهُ فَلِأُمِّهِ الثُّلُثُ..."</p>
                            <p style="margin: 5px 0 0 20px; font-size: 13px; color: #555;">➜ تطبق في نصيب الأم (1/3 عند عدم وجود الأبناء)</p>
                        </li>
                        <li style="margin-bottom: 15px; padding-bottom: 10px; border-bottom: 1px dashed #eee;">
                            <strong>🔸 سورة النساء 12:</strong>
                            <p style="margin: 5px 0 0 20px; font-size: 14px;">"وَلَكُمْ نِصْفُ مَا تَرَكَ أَزْوَاجُكُمْ إِن لَّمْ يَكُن لَّهُنَّ وَلَدٌ..."</p>
                            <p style="margin: 5px 0 0 20px; font-size: 13px; color: #555;">➜ تطبق في نصيب الزوج (1/2 بدون أبناء، 1/4 مع الأبناء)</p>
                        </li>
                        <li style="margin-bottom: 15px; padding-bottom: 10px; border-bottom: 1px dashed #eee;">
                            <strong>🔸 سورة النساء 12:</strong>
                            <p style="margin: 5px 0 0 20px; font-size: 14px;">"وَلَهُنَّ الرُّبُعُ مِمَّا تَرَكْتُمْ إِن لَّمْ يَكُن لَّكُمْ وَلَدٌ..."</p>
                            <p style="margin: 5px 0 0 20px; font-size: 13px; color: #555;">➜ تطبق في نصيب الزوجات (1/4 بدون أبناء، 1/8 مع الأبناء)</p>
                        </li>
                    </ul>
                </div>
                
                <!-- العمود الثاني: الشريعة الإسلامية -->
                <div style="flex: 1 1 300px; background: white; padding: 20px; border-radius: 12px; box-shadow: 0 3px 10px rgba(0,0,0,0.05);">
                    <h3 style="color: #0d3d4e; border-right: 4px solid #d4af37; padding-right: 10px;">⚖️ قواعد الشريعة الإسلامية</h3>
                    <ul style="list-style: none; padding-right: 0;">
                        <li style="margin-bottom: 15px;">
                            <strong>🔹 أصحاب الفروض:</strong>
                            <p style="margin: 5px 0 0 20px; font-size: 13px;">الذين لهم نصيب مقدر شرعاً: الزوج، الزوجات، الأم، الأب (في بعض الحالات)، الجد، الجدة، الأخوات...</p>
                        </li>
                        <li style="margin-bottom: 15px;">
                            <strong>🔹 العصبة:</strong>
                            <p style="margin: 5px 0 0 20px; font-size: 13px;">من يرث الباقي بعد أصحاب الفروض: الأبناء، الإخوة، الأعمام... ويقدم الأقرب درجة.</p>
                        </li>
                        <li style="margin-bottom: 15px;">
                            <strong>🔹 الحجب:</strong>
                            <p style="margin: 5px 0 0 20px; font-size: 13px;">بعض الورثة يسقطون بوجود آخرين (مثلاً: الأبناء يحجبون الإخوة).</p>
                        </li>
                        <li style="margin-bottom: 15px;">
                            <strong>🔹 الوصية الواجبة:</strong>
                            <p style="margin: 5px 0 0 20px; font-size: 13px;">في القانون الجزائري، إذا توفي الابن قبل الجد، يرث أبناؤه (الأحفاد) نصيب أبيهم بالوصية الواجبة (المادة 133).</p>
                        </li>
                        <li style="margin-bottom: 15px;">
                            <strong>🔹 تقديم الدين والوصية:</strong>
                            <p style="margin: 5px 0 0 20px; font-size: 13px;">يتم سداد ديون الموتى وتنفيذ الوصية (في حدود الثلث) قبل توزيع الميراث (إجماع فقهي).</p>
                        </li>
                    </ul>
                </div>
                
                <!-- العمود الثالث: القانون الجزائري -->
                <div style="flex: 1 1 300px; background: white; padding: 20px; border-radius: 12px; box-shadow: 0 3px 10px rgba(0,0,0,0.05);">
                    <h3 style="color: #0d3d4e; border-right: 4px solid #d4af37; padding-right: 10px;">📋 قانون الأسرة الجزائري</h3>
                    <ul style="list-style: none; padding-right: 0;">
                        <li style="margin-bottom: 15px;">
                            <strong>📌 المواد 126-138:</strong>
                            <p style="margin: 5px 0 0 20px; font-size: 13px;">تحدد هذه المواد الأحكام العامة للميراث، وتتبع في معظمها أحكام الشريعة الإسلامية.</p>
                        </li>
                        <li style="margin-bottom: 15px;">
                            <strong>📌 المادة 133 (الوصية الواجبة):</strong>
                            <p style="margin: 5px 0 0 20px; font-size: 13px;">"إذا توفي أحد فروع المتوفى قبله، ورث فروعه الذين يوجدون عند وفاته نصيب أصلهم في حدود الثلث..."</p>
                            <p style="margin: 5px 0 0 20px; font-size: 12px; color: #555;">➜ تطبق في حالة أبناء الأبناء المتوفى قبل الجد</p>
                        </li>
                        <li style="margin-bottom: 15px;">
                            <strong>📌 المادة 134 (تسوية الديون):</strong>
                            <p style="margin: 5px 0 0 20px; font-size: 13px;">يبدأ بتجهيز الميت، ثم سداد ديونه، ثم تنفيذ وصاياه، ثم توزيع الميراث.</p>
                        </li>
                        <li style="margin-bottom: 15px;">
                            <strong>📌 المادة 137 (حالات خاصة):</strong>
                            <p style="margin: 5px 0 0 20px; font-size: 13px;">تتناول حالات ميراث الحمل، المفقود، والخنثى المشكل.</p>
                        </li>
                        <li style="margin-bottom: 15px;">
                            <strong>📌 المادة 138 (الرد):</strong>
                            <p style="margin: 5px 0 0 20px; font-size: 13px;">إذا بقيت أموال بعد أصحاب الفروض وعدم وجود عصبة، ترد على بعض أصحاب الفروض (باستثناء الزوجين).</p>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- ملخص منهجية الحساب -->
            <div style="margin-top: 25px; padding: 20px; background: #e4f0f5; border-radius: 10px;">
                <h4 style="color: #0d3d4e; margin-top: 0;">🔍 منهجية عمل البرنامج:</h4>
                <ol style="line-height: 1.8; padding-right: 20px;">
                    <li><strong>الخطوة 1:</strong> طرح الديون من إجمالي التركة (تطبيقاً للمادة 134 من قانون الأسرة).</li>
                    <li><strong>الخطوة 2:</strong> توزيع أنصبة أصحاب الفروض (الزوج، الزوجات، الأم، الأب) حسب حالتهم (مع وجود أبناء أو بدون).</li>
                    <li><strong>الخطوة 3:</strong> توزيع الباقي (التعصيب) على الأبناء والبنات بنسبة 2:1 للذكر مثل حظ الأنثيين.</li>
                    <li><strong>الخطوة 4:</strong> التحقق من حالة الأحفاد (أبناء الأبناء): إذا توفي الابن قبل الجد، يرثون بالوصية الواجبة (المادة 133). إذا توفي بعد الجد، يرثون من تركة أبيهم (التي تشمل نصيبه من الجد).</li>
                </ol>
                <p style="margin-top: 15px; font-size: 14px; color: #555; font-style: italic;">* هذا البرنامج يطبق الأحكام وفقاً للقانون الجزائري والمذهب المالكي (المتبع في الجزائر). للفتوى الشرعية الدقيقة في الحالات المعقدة، راجع محكمة أو عالم متخصص.</p>
            </div>
        </div>

        <!-- =========================================== -->
        <!-- الفوتر (مع إضافة المراجع)                   -->
        <!-- =========================================== -->
        <div style="margin-top: 30px; font-size: 14px; color: #666; text-align: center; border-top: 1px solid #ddd; padding-top: 20px;">
            <p>⚠️ هذا البرنامج يقدم حسابات استرشادية حسب القانون الجزائري وأحكام الشريعة الإسلامية. للفتوى الشرعية الدقيقة، راجع عالم فقه موثوق.</p>
            <p style="font-size: 12px; margin-top: 5px;">المراجع: القرآن الكريم (سورة النساء)، قانون الأسرة الجزائري (المواد 126-138)، فتاوى المجلس الإسلامي الأعلى.</p>
        </div>
    </div>
    
    <script>
        // ... (كود الرسم البياني يبقى كما هو)
    </script>
</body>
</html>
</body>
</html>