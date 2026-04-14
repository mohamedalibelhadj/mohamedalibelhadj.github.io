<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>الحساب الذكي للميراث الشرعي - نسخة الجوال</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Naskh+Arabic:wght@400;500;600;700&family=Scheherazade+New:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* ========== المتغيرات الأساسية ========== */
        :root {
            --primary: #0d3d4e;
            --secondary: #1a6b7a;
            --accent: #d4af37;
            --light: #f5f2e9;
            --dark: #0a2d3a;
            --success: #2e7d32;
            --gold: #c9a227;
            --border-radius: 12px;
            --box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Noto Naskh Arabic', 'Scheherazade New', serif;
        }
        
        body {
            background: linear-gradient(135deg, var(--primary) 0%, var(--dark) 100%);
            color: #333;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
            padding: 0 10px;
        }
        
        body::before {
            content: "";
            position: fixed;
            top: 0;
            right: 0;
            width: 100%;
            height: 100%;
            background-image: 
                radial-gradient(circle at 20% 80%, rgba(212, 175, 55, 0.1) 0%, transparent 20%),
                radial-gradient(circle at 80% 20%, rgba(26, 107, 122, 0.1) 0%, transparent 20%),
                url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            z-index: -1;
        }
        
        /* ========== الهيدر المتحرك ========== */
        .header {
            background: linear-gradient(to left, var(--primary), var(--secondary));
            color: var(--light);
            padding: 1.2rem 1rem;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            position: relative;
            overflow: hidden;
            border-bottom: 5px solid var(--accent);
            border-radius: 0 0 20px 20px;
            margin: 0 -10px;
        }
        
        .header::before {
            content: "﷽";
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            font-size: 2.5rem;
            opacity: 0.15;
            color: var(--accent);
            font-family: 'Scheherazade New';
        }
        
        .header h1 {
            font-size: 1.8rem;
            margin-bottom: 0.3rem;
            font-weight: 700;
            color: var(--light);
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            position: relative;
            display: inline-block;
        }
        
        .header h1::after {
            content: "";
            position: absolute;
            bottom: -5px;
            right: 0;
            width: 100%;
            height: 2px;
            background: var(--accent);
            border-radius: 2px;
        }
        
        .header p {
            font-size: 1rem;
            opacity: 0.9;
            max-width: 800px;
            margin: 0 auto;
            line-height: 1.5;
            padding: 0 10px;
        }
        
        /* ========== الآية ========== */
        .verse {
            font-family: 'Scheherazade New';
            font-size: 1.1rem;
            color: var(--primary);
            text-align: center;
            padding: 0.8rem;
            margin: 1rem 0;
            background: rgba(212, 175, 55, 0.1);
            border-radius: 10px;
            border-right: 4px solid var(--accent);
            line-height: 1.6;
        }
        
        /* ========== الحاوية الرئيسية ========== */
        .main-container {
            max-width: 100%;
            margin: 1rem 0;
            background: var(--light);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
            border: 2px solid var(--accent);
            position: relative;
        }
        
        .main-container::before {
            content: "ﮋ";
            position: absolute;
            top: 10px;
            left: 10px;
            font-size: 2rem;
            color: var(--accent);
            opacity: 0.2;
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
        }
        
        .form-title {
            background: linear-gradient(to right, var(--primary), var(--secondary));
            color: white;
            padding: 1rem;
            text-align: center;
            font-size: 1.4rem;
            font-weight: 700;
            position: relative;
        }
        
        .form-title i {
            margin-left: 8px;
            color: var(--accent);
        }
        
        .form-content {
            padding: 1.2rem;
        }
        
        /* ========== عناوين الأقسام ========== */
        .section-title {
            background: var(--primary);
            color: white;
            padding: 8px 12px;
            border-radius: 8px;
            margin: 20px 0 12px 0;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        /* ========== تصميم حقول الإدخال ========== */
        .input-group {
            margin-bottom: 1.2rem;
            position: relative;
        }
        
        .input-group label {
            display: block;
            margin-bottom: 0.4rem;
            font-weight: 600;
            color: var(--dark);
            font-size: 1rem;
        }
        
        .input-group label i {
            margin-left: 6px;
            color: var(--secondary);
            width: 20px;
        }
        
        .input-group input, 
        .input-group select, 
        .input-group textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s;
            background: white;
            color: #333;
            -webkit-appearance: none;
            appearance: none;
        }
        
        .input-group input:focus, 
        .input-group select:focus, 
        .input-group textarea:focus {
            border-color: var(--secondary);
            box-shadow: 0 0 0 3px rgba(26, 107, 122, 0.2);
            outline: none;
        }
        
        .small-note {
            font-size: 0.75rem;
            color: #666;
            margin-top: 4px;
            font-style: italic;
            line-height: 1.4;
        }
        
        /* ========== شبكة الحقول ========== */
        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-bottom: 0.5rem;
        }
        
        @media (max-width: 380px) {
            .grid-2 {
                grid-template-columns: 1fr;
                gap: 5px;
            }
        }
        
        /* ========== الأزرار ========== */
        .buttons-container {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-top: 1.8rem;
        }
        
        .btn {
            padding: 14px 20px;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-align: center;
            width: 100%;
            -webkit-tap-highlight-color: transparent;
        }
        
        .btn:active {
            transform: scale(0.98);
        }
        
        .btn-primary {
            background: linear-gradient(to right, var(--primary), var(--secondary));
            color: white;
            box-shadow: 0 4px 10px rgba(13, 61, 78, 0.3);
        }
        
        .btn-secondary {
            background: linear-gradient(to right, var(--gold), #e0b22e);
            color: var(--dark);
            box-shadow: 0 4px 10px rgba(201, 162, 39, 0.3);
        }
        
        .btn-info {
            background: linear-gradient(to right, #17a2b8, #138496);
            color: white;
            box-shadow: 0 4px 10px rgba(23, 162, 184, 0.3);
        }
        
        /* ========== الفوتر ========== */
        .footer {
            background: linear-gradient(to left, var(--dark), var(--primary));
            color: var(--light);
            padding: 1.5rem 1rem;
            text-align: center;
            margin: 2rem -10px 0;
            border-top: 5px solid var(--accent);
            position: relative;
        }
        
        .footer::before {
            content: "";
            position: absolute;
            top: -5px;
            right: 0;
            width: 100%;
            height: 5px;
            background: repeating-linear-gradient(90deg, var(--accent), var(--accent) 8px, transparent 8px, transparent 16px);
        }
        
        .footer-content {
            max-width: 100%;
            margin: 0 auto;
        }
        
        .footer h3 {
            font-size: 1.3rem;
            margin-bottom: 0.8rem;
            color: var(--accent);
        }
        
        .footer p {
            margin-bottom: 0.8rem;
            line-height: 1.5;
            opacity: 0.9;
            font-size: 0.9rem;
        }
        
        .islamic-border {
            border: 2px solid var(--accent);
            border-radius: 10px;
            padding: 1.2rem;
            margin: 1.2rem auto;
            max-width: 100%;
            position: relative;
            background: rgba(255, 255, 255, 0.05);
        }
        
        /* ========== زر المساعدة ========== */
        .help-button {
            position: fixed;
            bottom: 20px;
            left: 20px;
            width: 55px;
            height: 55px;
            border-radius: 50%;
            background: var(--accent);
            color: white;
            border: none;
            font-size: 24px;
            cursor: pointer;
            z-index: 1000;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            -webkit-tap-highlight-color: transparent;
        }
        
        .help-button:active {
            transform: scale(0.95);
        }
        
        /* ========== الشات بوت ========== */
        .chatbot-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 55px;
            height: 55px;
            border-radius: 50%;
            background: linear-gradient(135deg, #1a6b7a, #0d3d4e);
            color: white;
            border: none;
            font-size: 24px;
            cursor: pointer;
            z-index: 2000;
            box-shadow: 0 6px 15px rgba(0,0,0,0.3);
            transition: 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .chatbot-button:active {
            transform: scale(0.95);
        }
        
        .chatbot-window {
            position: fixed;
            bottom: 85px;
            right: 15px;
            width: 300px;
            height: 400px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            display: none;
            flex-direction: column;
            overflow: hidden;
            z-index: 2000;
        }
        
        @media (max-width: 400px) {
            .chatbot-window {
                width: calc(100% - 30px);
                right: 15px;
                left: 15px;
                height: 350px;
            }
        }
        
        .chatbot-header {
            background: linear-gradient(to right, #0d3d4e, #1a6b7a);
            color: white;
            padding: 12px;
            text-align: center;
            font-weight: bold;
        }
        
        .chatbot-messages {
            flex: 1;
            padding: 10px;
            overflow-y: auto;
            font-size: 14px;
        }
        
        .chatbot-input {
            display: flex;
            border-top: 1px solid #ddd;
            padding: 8px;
        }
        
        .chatbot-input input {
            flex: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }
        
        .chatbot-input button {
            margin-left: 5px;
            padding: 10px 15px;
            background: #1a6b7a;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
        }
        
        .user-msg {
            background: #e3f2fd;
            margin: 8px 0;
            padding: 8px 12px;
            border-radius: 10px;
            max-width: 90%;
            align-self: flex-end;
        }
        
        .bot-msg {
            background: #e8f5e9;
            margin: 8px 0;
            padding: 8px 12px;
            border-radius: 10px;
            max-width: 90%;
        }
        
        /* ========== تحسينات إضافية للجوال ========== */
        @media (max-width: 480px) {
            .header h1 {
                font-size: 1.5rem;
            }
            
            .header p {
                font-size: 0.9rem;
            }
            
            .verse {
                font-size: 1rem;
                padding: 0.7rem;
            }
            
            .form-title {
                font-size: 1.2rem;
                padding: 0.8rem;
            }
            
            .section-title {
                font-size: 1rem;
                padding: 8px;
            }
            
            .input-group label {
                font-size: 0.95rem;
            }
            
            .btn {
                padding: 12px 16px;
                font-size: 0.95rem;
            }
        }
        
        /* إزالة التظليل عند النقر على العناصر في الجوال */
        input, select, button, a {
            -webkit-tap-highlight-color: transparent;
        }
        
        /* تحسين التمرير */
        .chatbot-messages {
            scrollbar-width: thin;
            scrollbar-color: var(--secondary) #f0f0f0;
        }
        
        .chatbot-messages::-webkit-scrollbar {
            width: 5px;
        }
        
        .chatbot-messages::-webkit-scrollbar-track {
            background: #f0f0f0;
        }
        
        .chatbot-messages::-webkit-scrollbar-thumb {
            background: var(--secondary);
            border-radius: 5px;
        }
        
        /* تحسين الحقول المخفية */
        #ابناء_الابناء_وقت, #بنات_البنات_وقت, #وصية_حاوية {
            transition: all 0.3s ease;
        }
    </style>
</head>
<body>
    <!-- عناصر زخرفية -->
    <div class="arabesque arabesque-1"></div>
    <div class="arabesque arabesque-2"></div>
    
    <!-- الهيدر الإسلامي -->
    <header class="header">
        <h1><i class="fas fa-mosque"></i> الحساب الذكي للميراث الشرعي</h1>
        <p>برنامج حساب المواريث وفقاً لأحكام الشريعة الإسلامية المستمدة من القرآن الكريم والسنة النبوية</p>
    </header>
    
    <!-- شريط زخرفي -->
    <div class="islamic-pattern"></div>
    
    <!-- الآية القرآنية -->
    <div class="verse">
        ﴿يُوصِيكُمُ اللَّهُ فِي أَوْلَادِكُمْ ۖ لِلذَّكَرِ مِثْلُ حَظِّ الْأُنثَيَيْنِ﴾ [النساء: 11]
    </div>
    
    <!-- الحاوية الرئيسية -->
    <div class="main-container">
        <div class="form-title">
            <i class="fas fa-calculator"></i> أدخل بيانات الورثة - قانون الأسرة الجزائري
        </div>
        
        <div class="form-content">
            <form method="post" action="calcul.php" id="inheritanceForm">
                
                <!-- القسم 1: بيانات المتوفى -->
                <div class="section-title">
                    <i class="fas fa-user-circle"></i> بيانات المتوفى
                </div>
                
                <div class="grid-2">
                    <div class="input-group">
                        <label><i class="fas fa-user"></i> جنس المتوفى</label>
                        <select name="جنس_المتوفى" id="جنس_المتوفى" required>
                            <option value="ذكر">ذكر</option>
                            <option value="أنثى">أنثى</option>
                        </select>
                    </div>
                    
                    <div class="input-group">
                        <label><i class="fas fa-dna"></i> المبلغ الإجمالي (دج)</label>
                        <input type="number" name="المبلغ" min="0" step="0.01" value="0" required>
                        <div class="small-note">المبلغ قبل خصم الديون</div>
                    </div>
                </div>
                
                <!-- القسم 2: الديون والوصية -->
                <div class="section-title">
                    <i class="fas fa-file-contract"></i> الديون والوصية
                </div>
                
                <div class="grid-2">
                    <div class="input-group">
                        <label><i class="fas fa-money-bill-wave"></i> قيمة الديون (دج)</label>
                        <input type="number" name="ديون" min="0" step="0.01" value="0">
                        <div class="small-note">الديون المستحقة (تخصم أولاً)</div>
                    </div>
                    
                    <div class="input-group">
                        <label><i class="fas fa-hand-holding-heart"></i> هل يوجد وصية؟</label>
                        <select name="هل_يوجد_وصية" id="هل_يوجد_وصية">
                            <option value="0">لا</option>
                            <option value="1">نعم</option>
                        </select>
                    </div>
                </div>
                
                <div class="input-group" id="وصية_حاوية" style="display: none;">
                    <label><i class="fas fa-pen-fancy"></i> قيمة الوصية</label>
                    <input type="text" name="قيمة_الوصية" placeholder="مثال: 1/3 أو 0.2 أو 20%">
                    <div class="small-note">أقصى حد للوصية هو الثلث (1/3)</div>
                </div>
                
                <!-- القسم 3: الأزواج -->
                <div class="section-title">
                    <i class="fas fa-heart"></i> بيانات الأزواج
                </div>
                
                <div class="grid-2">
                    <div class="input-group" id="زوج_زوجة_حاوية">
                        <!-- سيتم تعبئة هذا الحقل ديناميكياً -->
                    </div>
                    
                    <div class="input-group" id="حقل_إضافي">
                        <!-- سيتم تعبئته حسب الحالة -->
                    </div>
                </div>
                
                <!-- القسم 4: الأبناء والأحفاد -->
                <div class="section-title">
                    <i class="fas fa-baby"></i> الأبناء والأحفاد
                </div>
                
                <div class="grid-2">
                    <div class="input-group">
                        <label><i class="fas fa-male"></i> عدد الأبناء الذكور</label>
                        <input type="number" name="أبناء" min="0" value="0" required>
                    </div>
                    
                    <div class="input-group">
                        <label><i class="fas fa-female"></i> عدد البنات</label>
                        <input type="number" name="بنات" min="0" value="0" required>
                    </div>
                </div>
                
                <!-- أبناء الأبناء -->
                <div class="grid-2">
                    <div class="input-group">
                        <label><i class="fas fa-male"></i> عدد أبناء الأبناء</label>
                        <input type="number" name="أبناء_الأبناء" min="0" value="0" id="ابناء_الابناء">
                        <div class="small-note">أولاد الابن المتوفى</div>
                    </div>
                    
                    <div class="input-group" id="ابناء_الابناء_وقت" style="display: none;">
                        <label><i class="fas fa-clock"></i> وقت وفاة أبوهم</label>
                        <select name="وفاة_ابناء_الابناء">
                            <option value="بعد">توفي بعد الجد</option>
                            <option value="قبل" selected>توفي قبل الجد</option>
                        </select>
                        <div class="small-note">🔴 إذا توفي قبل الجد: الوصية الواجبة</div>
                    </div>
                </div>
                
                <!-- بنات البنات -->
                <div class="grid-2">
                    <div class="input-group">
                        <label><i class="fas fa-female"></i> عدد بنات البنات</label>
                        <input type="number" name="بنات_البنات" min="0" value="0" id="بنات_البنات">
                        <div class="small-note">بنات البنت المتوفاة</div>
                    </div>
                    
                    <div class="input-group" id="بنات_البنات_وقت" style="display: none;">
                        <label><i class="fas fa-clock"></i> وقت وفاة أمهن</label>
                        <select name="وفاة_بنات_البنات">
                            <option value="بعد">توفيت بعد الجد</option>
                            <option value="قبل" selected>توفيت قبل الجد</option>
                        </select>
                        <div class="small-note">🔴 إذا توفيت قبل الجد: الوصية الواجبة</div>
                    </div>
                </div>
                
                <!-- القسم 5: الوالدين -->
                <div class="section-title">
                    <i class="fas fa-users"></i> الوالدين
                </div>
                
                <div class="grid-2">
                    <div class="input-group">
                        <label><i class="fas fa-user-tie"></i> هل الأب موجود؟</label>
                        <select name="أب" required>
                            <option value="0">لا</option>
                            <option value="1">نعم</option>
                        </select>
                    </div>
                    
                    <div class="input-group">
                        <label><i class="fas fa-user-tie"></i> هل الأم موجودة؟</label>
                        <select name="أم" required>
                            <option value="0">لا</option>
                            <option value="1">نعم</option>
                        </select>
                    </div>
                </div>
                
                <!-- أزرار التحكم -->
                <div class="buttons-container">
                    <button type="submit" name="حساب_الميراث" class="btn btn-primary">
                        <i class="fas fa-balance-scale"></i> احسب تقسيم الميراث
                    </button>
                    
                    <button type="button" class="btn btn-secondary" onclick="window.open('https://cwoste-sba.dz/mirath/ind.php', '_blank')">
                        <i class="fas fa-external-link-alt"></i> الحاسبة المتقدمة
                    </button>
                    
                    <button type="button" class="btn btn-info" onclick="window.open('https://cwoste-sba.dz/mirath/', '_blank')">
                        <i class="fas fa-info-circle"></i> معلومات إضافية
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- الفوتر الإسلامي -->
    <footer class="footer">
        <div class="footer-content">
            <div class="islamic-border">
                <h3><i class="fas fa-star-and-crescent"></i> تنبيه هام</h3>
                <p>هذا البرنامج يقدم حسابات استرشادية وفقاً لأحكام الميراث في الشريعة الإسلامية وقانون الأسرة الجزائري. للفتوى الشرعية الدقيقة يرجع إلى علماء الفقه الموثوقين.</p>
            </div>
            <p>جميع الحقوق محفوظة © 2026 | نظام حساب المواريث الشرعية</p>
            <p>تصميم إسلامي بروح عربية أصيلة</p>
            <p>إعداد: يحي علي بلحاج - كشوت عبد النور</p>
            <p>الثانوية الجهوية للرياضيات "الخوارزمي" - ولاية سيدي بلعباس</p>
        </div>
    </footer>

    <!-- زر المساعدة -->
    <button class="help-button" onclick="showHelp()">
        <i class="fas fa-question"></i>
    </button>

    <!-- زر الشات بوت -->
    <button class="chatbot-button" onclick="toggleChat()">
        <i class="fas fa-robot"></i>
    </button>

    <!-- نافذة الشات -->
    <div class="chatbot-window" id="chatbot">
        <div class="chatbot-header">
            🤖 مساعد الميراث
        </div>
        <div class="chatbot-messages" id="chatMessages">
            <div class="bot-msg">
                السلام عليكم 👋<br>
                أنا مساعد الميراث.<br>
                يمكنك سؤالي مثل:<br>
                - ما نصيب الزوجة؟<br>
                - ما هو العول؟<br>
                - ما هو الحجب؟
            </div>
        </div>
        <form class="chatbot-input" onsubmit="sendChat(); return false;">
            <input type="text" id="chatInput" placeholder="اكتب سؤالك هنا">
            <button type="submit" id="sendBtn">إرسال</button>
        </form>
    </div>

    <script>
        // دالة لتحديث حقول الزوج/الزوجة حسب جنس المتوفى
        function updateSpouseFields() {
            const genderSelect = document.getElementById('جنس_المتوفى');
            const spouseContainer = document.getElementById('زوج_زوجة_حاوية');
            const additionalField = document.getElementById('حقل_إضافي');
            
            if (genderSelect.value === 'ذكر') {
                spouseContainer.innerHTML = `
                    <label><i class="fas fa-female"></i> عدد الزوجات</label>
                    <select name="زوجات" id="زوجات" required>
                        <option value="0">لا يوجد</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                    </select>
                    <div class="small-note">الحد الأقصى 4 زوجات</div>
                `;
                
                additionalField.innerHTML = `
                    <label><i class="fas fa-users"></i> عدد الزوجات المتوفيات</label>
                    <input type="number" name="زوجات_متوفيات" min="0" max="4" value="0">
                `;
            } else {
                spouseContainer.innerHTML = `
                    <label><i class="fas fa-male"></i> هل يوجد زوج؟</label>
                    <select name="زوج" id="زوج" required>
                        <option value="0">لا</option>
                        <option value="1">نعم</option>
                    </select>
                    <div class="small-note">للزوج النصيب الشرعي</div>
                `;
                
                additionalField.innerHTML = `
                    <label><i class="fas fa-users"></i> عدد الأزواج السابقين</label>
                    <input type="number" name="أزواج_سابقين" min="0" value="0">
                `;
            }
        }
        
        // دالة لإظهار/إخفاء حقل الوصية
        function toggleWillField() {
            const willSelect = document.getElementById('هل_يوجد_وصية');
            const willContainer = document.getElementById('وصية_حاوية');
            
            if (willSelect.value === '1') {
                willContainer.style.display = 'block';
            } else {
                willContainer.style.display = 'none';
                willContainer.querySelector('input[name="قيمة_الوصية"]').value = '';
            }
        }
        
        // دالة لإظهار/إخفاء حقول وقت الوفاة
        function toggleDeathTimeFields() {
            const ابناءالابناء = document.getElementById('ابناء_الابناء');
            const ابناءوقت = document.getElementById('ابناء_الابناء_وقت');
            const بناتالبنات = document.getElementById('بنات_البنات');
            const بناتوقت = document.getElementById('بنات_البنات_وقت');
            
            if (ابناءالابناء && ابناءوقت) {
                ابناءوقت.style.display = ابناءالابناء.value > 0 ? 'block' : 'none';
            }
            
            if (بناتالبنات && بناتوقت) {
                بناتوقت.style.display = بناتالبنات.value > 0 ? 'block' : 'none';
            }
        }
        
        // دالة المساعدة
        function showHelp() {
            alert('❓ مساعدة - قانون الأسرة الجزائري:\n\n' +
                  '1. الديون: تخصم أولاً من التركة\n' +
                  '2. الوصية: أقصاها ثلث الباقي بعد الديون\n' +
                  '3. توزيع الباقي حسب الأنصبة الشرعية\n' +
                  '4. الذكر يأخذ ضعف الأنثى في نفس الدرجة\n' +
                  '5. الأقرباء يحجبون الأبعد\n' +
                  '6. في حالة العول: تنقص الأنصبة نسبياً');
        }
        
        // دوال الشات بوت
        function toggleChat() {
            const chat = document.getElementById('chatbot');
            chat.style.display = chat.style.display === 'flex' ? 'none' : 'flex';
        }
        
        function sendChat() {
            let input = document.getElementById('chatInput');
            let msg = input.value.trim();
            
            if (msg === '') return;
            
            let chat = document.getElementById('chatMessages');
            chat.innerHTML += "<div class='user-msg'>👤 " + msg + "</div>";
            
            // محاكاة رد (يمكن استبدالها بـ fetch حقيقي)
            setTimeout(() => {
                chat.innerHTML += "<div class='bot-msg'>🤖 شكراً لسؤالك. هذا سؤال يحتاج إلى فتوى شرعية متخصصة.</div>";
                chat.scrollTop = chat.scrollHeight;
            }, 500);
            
            input.value = '';
        }
        
        // التحقق من صحة البيانات قبل الإرسال
        document.getElementById('inheritanceForm').addEventListener('submit', function(e) {
            const totalAmount = document.querySelector('input[name="المبلغ"]').value;
            const debts = document.querySelector('input[name="ديون"]').value;
            
            if (totalAmount <= 0) {
                e.preventDefault();
                alert('⚠️ يرجى إدخال مبلغ الميراث الإجمالي');
                return false;
            }
            
            if (parseFloat(debts) > parseFloat(totalAmount)) {
                e.preventDefault();
                alert('⚠️ قيمة الديون لا يمكن أن تتجاوز المبلغ الإجمالي');
                return false;
            }
            
            // تأكيد قبل الإرسال
            if (!confirm('هل أنت متأكد من صحة البيانات المدخلة؟')) {
                e.preventDefault();
                return false;
            }
        });
        
        // تهيئة الصفحة
        document.addEventListener('DOMContentLoaded', function() {
            updateSpouseFields();
            toggleWillField();
            toggleDeathTimeFields();
            
            document.getElementById('جنس_المتوفى').addEventListener('change', updateSpouseFields);
            document.getElementById('هل_يوجد_وصية').addEventListener('change', toggleWillField);
            
            if (document.getElementById('ابناء_الابناء')) {
                document.getElementById('ابناء_الابناء').addEventListener('input', toggleDeathTimeFields);
            }
            
            if (document.getElementById('بنات_البنات')) {
                document.getElementById('بنات_البنات').addEventListener('input', toggleDeathTimeFields);
            }
        });
        
        // منع النقر بالزر الأيمن
        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
            alert('النقر بالزر الأيمن غير متاح!');
        });
    </script>
</body>
</html>