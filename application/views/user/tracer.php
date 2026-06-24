<?php
$survey_response = $response ?? [];

$competency_values = [];
if (!empty($survey_response['competencies'])) {
    $decoded_competencies = json_decode($survey_response['competencies'], true);
    if (is_array($decoded_competencies)) {
        $competency_values = $decoded_competencies;
    }
}

$subject_values = [];
if (!empty($survey_response['subjects'])) {
    $decoded_subjects = json_decode($survey_response['subjects'], true);
    if (is_array($decoded_subjects)) {
        $subject_values = $decoded_subjects;
    }
}

$satisfaction_value = $survey_response['satisfaction'] ?? '';
$intent_value = $survey_response['intent'] ?? '';
$other_intent = $survey_response['other_intent'] ?? '';

$performance_values = [];
if (!empty($survey_response['performance_ratings'])) {
    $decoded_perf = json_decode($survey_response['performance_ratings'], true);
    if (is_array($decoded_perf)) {
        $performance_values = $decoded_perf;
    }
}

$further_study = [];
if (!empty($survey_response['further_study'])) {
    $decoded_fs = json_decode($survey_response['further_study'], true);
    if (is_array($decoded_fs)) {
        $further_study = $decoded_fs;
    }
}

$question_statements = [
    'Developed my knowledge and skills applicable to a career.',
    'Provided me with a broad overview of my course/major.',
    'Stimulated my enthusiasm for further learning.',
    'Improved my skills in oral and written communication.',
];

$waiting_options = [
    'Less than a month',
    'Less than a year',
    '1 year to less than 2 years',
    'more than 2 years',
];

$competency_options = [
    'Communication skills',
    'Human relations skills',
    'Entrepreneurial skills',
    'Information Technology skills',
    'Problem Solving skills',
    'Critical thinking skills',
    'Collaboration skills',
];

$subject_options = [
    'Communication Skills/Arts',
    'Computer Programming skills',
    'Math',
    'Computer Concepts',
    'Database Systems',
    'Logic',
    'Computer Graphics',
    'Professional Ethics',
    'All major subjects',
];

$performance_statements = [
    'I am able to complete my tasks in a professional manner.',
    'I am committed and dedicated to my work at all times.',
    'I use company resources to their maximum level with initiative & resourcefulness.',
    'I work harmoniously with my peers, co-employees and superiors.',
    'I report to work promptly and regularly.',
    'I join all company activities with enthusiasm.',
];
?>

<style>
    :root {
        --tracer-bg: #f3f4f6;
        --tracer-card: #ffffff;
        --tracer-border: #d1d5db;
        --tracer-text: #1f2937;
        --tracer-muted: #6b7280;
        --tracer-header: #9ca3af;
        --tracer-accent: #a12124;
        --tracer-shadow: 0 1px 3px rgba(0,0,0,0.08);
    }

    .tracer-page {
        max-width: 900px;
        margin: 0 auto;
        padding: 20px 16px 48px;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        color: var(--tracer-text);
    }

    .tracer-hero {
        background: linear-gradient(135deg, #ffffff, #f8fafc);
        border: 1px solid var(--tracer-border);
        border-radius: 12px;
        box-shadow: var(--tracer-shadow);
        overflow: hidden;
        margin-bottom: 16px;
    }

    .tracer-hero-bar {
        background: #a12124;
        color: white;
        padding: 8px 14px;
        font-size: 14px;
        font-weight: 600;
    }

    .tracer-hero-body {
        padding: 18px 14px 14px;
    }

    .tracer-title {
        font-size: 14px;
        line-height: 1.45;
        margin-bottom: 14px;
        color: var(--tracer-text);
        font-weight: 700;
    }

    .tracer-section {
        background: var(--tracer-card);
        border: 1px solid var(--tracer-border);
        border-radius: 12px;
        box-shadow: var(--tracer-shadow);
        margin-bottom: 16px;
        overflow: hidden;
    }

    .tracer-section-head {
        padding: 14px 16px 8px;
        color: var(--tracer-text);
        font-weight: 700;
        font-size: 14px;
    }

    .tracer-section-body {
        padding: 0 16px 16px;
    }

    .rating-scale {
        display: grid;
        grid-template-columns: 1.9fr repeat(5, minmax(0, 1fr));
        gap: 0;
        align-items: stretch;
        margin-top: 10px;
    }

    .rating-scale .scale-label {
        font-size: 12px;
        text-align: center;
        color: var(--tracer-text);
        line-height: 1.2;
        padding: 0 6px 10px;
    }

    .rating-row {
        display: grid;
        grid-template-columns: 1.9fr repeat(5, minmax(0, 1fr));
        align-items: center;
        padding: 12px 0;
        border-top: 1px solid #f1f5f9;
    }

    .rating-row:first-of-type {
        margin-top: 2px;
    }

    .rating-question {
        font-size: 12px;
        line-height: 1.35;
        padding-right: 10px;
        color: var(--tracer-text);
    }

    .rating-option {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .rating-option input,
    .check-option input {
        width: 16px;
        height: 16px;
        accent-color: var(--tracer-accent);
        cursor: pointer;
    }

    .check-group {
        display: grid;
        gap: 12px;
        margin-top: 8px;
    }

    .check-option {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 13px;
        color: var(--tracer-text);
    }

    .tracer-actions {
        display: flex;
        gap: 10px;
        justify-content: flex-end;
        margin-top: 18px;
    }

    .tracer-actions .btn {
        border-radius: 8px;
        padding: 10px 22px;
        font-weight: 600;
    }

    .tracer-btn-primary {
        background: linear-gradient(135deg, #a12124, #7d181b);
        border: none;
        color: white;
        box-shadow: none;
    }

    a.tracer-btn-primary,
    a.tracer-btn-primary:hover,
    a.tracer-btn-primary:focus,
    a.tracer-btn-primary:active,
    a.tracer-btn-primary:visited {
        color: white !important;
        -webkit-text-fill-color: white !important;
        text-decoration: none !important;
        opacity: 1 !important;
    }

    a.tracer-btn-primary i,
    a.tracer-btn-primary:hover i,
    a.tracer-btn-primary:focus i,
    a.tracer-btn-primary:active i,
    a.tracer-btn-primary:visited i {
        color: white !important;
        -webkit-text-fill-color: white !important;
    }

    .tracer-btn-secondary {
        border: 1px solid var(--tracer-border);
        background: white;
        color: var(--tracer-text);
    }

    .tracer-btn-primary:hover,
    .tracer-btn-secondary:hover {
        transform: translateY(-1px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    }

    .tracer-btn-primary:hover {
        color: white !important;
        background: linear-gradient(135deg, #7d181b, #a12124);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }

    .tracer-alert {
        border-radius: 10px;
        margin-bottom: 14px;
    }

    @media (max-width: 768px) {
        .tracer-page { padding: 12px 10px 36px; }
        .rating-scale,
        .rating-row {
            grid-template-columns: 1fr;
        }
        .rating-scale { display: none; }
        .rating-row {
            gap: 10px;
            padding: 14px 0;
        }
        .rating-question { padding-right: 0; }
        .rating-option {
            justify-content: flex-start;
            padding-left: 2px;
        }
        .rating-option::after {
            content: attr(data-label);
            margin-left: 8px;
            font-size: 12px;
            color: var(--tracer-muted);
        }
        .tracer-actions {
            flex-direction: column;
        }
        .tracer-actions .btn {
            width: 100%;
        }
    }
</style>

<div class="tracer-page">
    <div class="tracer-hero">
        <div class="tracer-hero-bar">Tracer Survey</div>
    </div>

    <?php if ($this->session->flashdata('tracer_error')): ?>
        <div class="alert alert-danger tracer-alert"><?= $this->session->flashdata('tracer_error'); ?></div>
    <?php elseif ($this->session->flashdata('tracer_success')): ?>
        <div class="alert alert-success tracer-alert"><?= $this->session->flashdata('tracer_success'); ?></div>
    <?php endif; ?>

    <form id="tracer-form" action="<?= base_url('tracer/submit') ?>" method="post">
        <input type="hidden" name="_wizard" value="1">

        <?php // Step wrapper: place multiple tracer-section blocks inside for a cleaner layout ?>
        <div class="step" data-step="1">
            <div class="tracer-section">
                <div class="tracer-section-head">A. How would you rate the contribution of the program of your study at the institution to your personal knowledge, skills and attitudes?</div>
                <div class="tracer-section-body">
                    <div class="rating-scale">
                        <div></div>
                        <div class="scale-label">5 - Strongly<br>Agree</div>
                        <div class="scale-label">4 - Agree</div>
                        <div class="scale-label">3 - Neutral</div>
                        <div class="scale-label">2 - Disagree</div>
                        <div class="scale-label">1 - Strongly<br>Disagree</div>
                    </div>

                    <?php foreach ($question_statements as $index => $statement): ?>
                        <div class="rating-row">
                            <div class="rating-question"><?= htmlspecialchars($statement) ?></div>
                            <?php for ($rating = 5; $rating >= 1; $rating--): ?>
                                <div class="rating-option" data-label="<?= $rating ?>">
                                    <input type="radio" name="ratings[<?= $index ?>]" value="<?= $rating ?>" <?= (isset($survey_response['rating_' . ($index + 1)]) && (int)$survey_response['rating_' . ($index + 1)] === $rating) ? 'checked' : '' ?> required>
                                </div>
                            <?php endfor; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="tracer-section">
                <div class="tracer-section-head">B. Waiting time to get the first job?</div>
                <div class="tracer-section-body">
                    <div class="check-group">
                        <?php foreach ($waiting_options as $option): ?>
                            <label class="check-option">
                                <input type="radio" name="waiting_time" value="<?= htmlspecialchars($option) ?>" <?= (!empty($survey_response['waiting_time']) && $survey_response['waiting_time'] === $option) ? 'checked' : '' ?> required>
                                <span><?= htmlspecialchars($option) ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="tracer-section">
                <div class="tracer-section-head">C. Competencies learned in College useful in present job?</div>
                <div class="tracer-section-body">
                    <div class="check-group">
                        <?php foreach ($competency_options as $option): ?>
                            <label class="check-option">
                                <input type="checkbox" name="competencies[]" value="<?= htmlspecialchars($option) ?>" <?= in_array($option, $competency_values, true) ? 'checked' : '' ?>>
                                <span><?= htmlspecialchars($option) ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <?php $base = 2; ?>

        
            <div class="step" data-step="<?= $base ?>" style="display:none;">
                <div class="tracer-section">
                    <div class="tracer-section-head">D. Subjects that greatly helped you in getting your job now?</div>
                    <div class="tracer-section-body">
                        <div class="check-group">
                            <?php foreach ($subject_options as $option): ?>
                                <label class="check-option">
                                    <input type="checkbox" name="subjects[]" value="<?= htmlspecialchars($option) ?>" <?= in_array($option, $subject_values, true) ? 'checked' : '' ?>>
                                    <span><?= htmlspecialchars($option) ?></span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <div class="tracer-section">
                    <div class="tracer-section-head">E. How satisfied are you with your current job?</div>
                    <div class="tracer-section-body">
                        <div class="check-group">
                            <?php $s_options = ['Very Much','Much','A Little','Not Satisfied']; ?>
                            <?php foreach ($s_options as $opt): ?>
                                <label class="check-option">
                                    <input type="radio" name="satisfaction" value="<?= htmlspecialchars($opt) ?>" <?= ($satisfaction_value === $opt) ? 'checked' : '' ?> required>
                                    <span><?= htmlspecialchars($opt) ?></span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <div class="tracer-section">
                    <div class="tracer-section-head">F. Do you intend to stay in the same job/profession?</div>
                    <div class="tracer-section-body">
                        <?php
                            $i_options = [
                                'Yes',
                                'No, I intend to look for better paying employer..',
                                'No, I intend to change career.',
                                'No, I intend to open my own business',
                                'No, I intend to work overseas.',
                                'No, (state other reason)'
                            ];
                        ?>
                        <div class="check-group">
                            <?php foreach ($i_options as $opt): ?>
                                <label class="check-option">
                                    <input type="radio" name="intent" value="<?= htmlspecialchars($opt) ?>" <?= ($intent_value === $opt) ? 'checked' : '' ?> required>
                                    <span><?= htmlspecialchars($opt) ?></span>
                                </label>
                            <?php endforeach; ?>
                            <label class="check-option" style="margin-top:8px;">
                                <input type="text" name="other_intent" placeholder="If other, please explain" value="<?= htmlspecialchars($other_intent) ?>" style="flex:1;padding:8px;border:1px solid var(--tracer-border);border-radius:6px;background:#fff;">
                            </label>
                        </div>
                    </div>
                </div>
            </div>

        <div class="tracer-section step" data-step="<?= $base + 1 ?>" style="display:none;">
            <div class="tracer-section-head">G. How do you rate your performance level in your present job?</div>
            <div class="tracer-section-body">
                <div class="rating-scale">
                    <div></div>
                    <div class="scale-label">5-Outstanding</div>
                    <div class="scale-label">4-Very<br>Satisfactory</div>
                    <div class="scale-label">3-Satisfactory</div>
                    <div class="scale-label">2-Needs<br>Improvement</div>
                    <div class="scale-label">1-Poor</div>
                </div>

                <?php foreach ($performance_statements as $pindex => $pstmt): ?>
                    <div class="rating-row">
                        <div class="rating-question"><?= htmlspecialchars($pstmt) ?></div>
                        <?php for ($pr = 5; $pr >= 1; $pr--): ?>
                            <div class="rating-option" data-label="<?= $pr ?>">
                                <input type="radio" name="performance_ratings[<?= $pindex ?>]" value="<?= $pr ?>" <?= (isset($performance_values[$pindex]) && (int)$performance_values[$pindex] === $pr) ? 'checked' : '' ?> required>
                            </div>
                        <?php endfor; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="tracer-section step" data-step="<?= $base + 2 ?>" style="display:none;">
            <div class="tracer-section-head">H. If pursuing further study:</div>
            <div class="tracer-section-body">
                <label style="display:block;margin-bottom:8px;">Enrollment Year:</label>
                <input type="text" name="enrollment_year" value="<?= htmlspecialchars($further_study['enrollment_year'] ?? '') ?>" style="width:100%;padding:8px;border:1px solid var(--tracer-border);border-radius:6px;margin-bottom:10px;background:#fff;">

                <label style="display:block;margin-bottom:8px;">Program:</label>
                <input type="text" name="program" value="<?= htmlspecialchars($further_study['program'] ?? '') ?>" style="width:100%;padding:8px;border:1px solid var(--tracer-border);border-radius:6px;margin-bottom:10px;background:#fff;">

                <label style="display:block;margin-bottom:8px;">Level:</label>
                <input type="text" name="level" value="<?= htmlspecialchars($further_study['level'] ?? '') ?>" style="width:100%;padding:8px;border:1px solid var(--tracer-border);border-radius:6px;margin-bottom:10px;background:#fff;">

                <label style="display:block;margin-bottom:8px;">Campus:</label>
                <input type="text" name="campus" value="<?= htmlspecialchars($further_study['campus'] ?? '') ?>" style="width:100%;padding:8px;border:1px solid var(--tracer-border);border-radius:6px;margin-bottom:10px;background:#fff;">
            </div>
        </div>

        <div class="tracer-actions" style="justify-content:space-between;">
            <div>
                <a href="<?= base_url('profile') ?>" class="btn tracer-btn-secondary">Back to Profile</a>
            </div>
            <div style="display:flex;gap:8px;">
                <button type="button" id="prev-step" class="btn tracer-btn-secondary" style="display:none;">Previous</button>
                <button type="button" id="next-step" class="btn tracer-btn-primary">Next</button>
                <button type="submit" id="submit-btn" class="btn tracer-btn-primary" style="display:none;">Save Tracer Response</button>
            </div>
        </div>
    </form>
</div>

<script>
(function () {
    var currentStep = 1;
    var totalSteps = document.querySelectorAll('.step').length;
    var nextBtn = document.getElementById('next-step');
    var prevBtn = document.getElementById('prev-step');
    var submitBtn = document.getElementById('submit-btn');

    function showStep(n) {
        document.querySelectorAll('.step').forEach(function (el) {
            el.style.display = el.getAttribute('data-step') == n ? '' : 'none';
        });
        prevBtn.style.display = n > 1 ? '' : 'none';
        nextBtn.style.display = n < totalSteps ? '' : 'none';
        submitBtn.style.display = n === totalSteps ? '' : 'none';
        window.scrollTo({top:0,behavior:'smooth'});
    }

    function validateStep(n) {
        var step = document.querySelector('.step[data-step="' + n + '"]');
        if (!step) return true;
        var required = step.querySelectorAll('input[required]');
        for (var i=0;i<required.length;i++){
            var el = required[i];
            if ((el.type === 'radio' || el.type === 'checkbox')) {
                var name = el.name;
                var els = document.getElementsByName(name);
                var any = false;
                for (var k=0;k<els.length;k++) { if (els[k].checked) { any = true; break; } }
                if (!any) return false;
            } else if (!el.value) {
                return false;
            }
        }
        return true;
    }

    nextBtn.addEventListener('click', function () {
        if (!validateStep(currentStep)) {
            alert('Please complete required fields on this step.');
            return;
        }
        if (currentStep < totalSteps) {
            currentStep++;
            showStep(currentStep);
        }
    });

    prevBtn.addEventListener('click', function () {
        if (currentStep > 1) {
            currentStep--;
            showStep(currentStep);
        }
    });

    showStep(currentStep);
})();
</script>