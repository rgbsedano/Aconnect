<?php
$survey_response = $response ?? [];
$competency_values = [];
if (!empty($survey_response['competencies'])) {
    $decoded_competencies = json_decode($survey_response['competencies'], true);
    if (is_array($decoded_competencies)) {
        $competency_values = $decoded_competencies;
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
        <div class="tracer-hero-body">
            <div class="tracer-title">
                D. How would you rate the contribution of the program of your study at the institution to your personal knowledge, skills and attitudes?
            </div>
        </div>
    </div>

    <?php if ($this->session->flashdata('tracer_error')): ?>
        <div class="alert alert-danger tracer-alert"><?= $this->session->flashdata('tracer_error'); ?></div>
    <?php elseif ($this->session->flashdata('tracer_success')): ?>
        <div class="alert alert-success tracer-alert"><?= $this->session->flashdata('tracer_success'); ?></div>
    <?php endif; ?>

    <form action="<?= base_url('tracer/submit') ?>" method="post">
        <div class="tracer-section">
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
            <div class="tracer-section-head">E. Waiting time to get the first job?</div>
            <div class="tracer-section-body">
                <div class="check-group">
                    <?php foreach ($waiting_options as $option): ?>
                        <label class="check-option">
                            <input type="checkbox" name="waiting_time" value="<?= htmlspecialchars($option) ?>" <?= (!empty($survey_response['waiting_time']) && $survey_response['waiting_time'] === $option) ? 'checked' : '' ?>>
                            <span><?= htmlspecialchars($option) ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="tracer-section">
            <div class="tracer-section-head">F. Competencies learned in College useful in present job?</div>
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

        <div class="tracer-actions">
            <a href="<?= base_url('profile') ?>" class="btn tracer-btn-secondary">Back to Profile</a>
            <button type="submit" class="btn tracer-btn-primary">Save Tracer Response</button>
        </div>
    </form>
</div>

<script>
(function () {
    var waitBoxes = document.querySelectorAll('input[name="waiting_time"]');
    waitBoxes.forEach(function (box) {
        box.addEventListener('change', function () {
            if (!this.checked) {
                return;
            }

            waitBoxes.forEach(function (other) {
                if (other !== box) {
                    other.checked = false;
                }
            });
        });
    });
})();
</script>