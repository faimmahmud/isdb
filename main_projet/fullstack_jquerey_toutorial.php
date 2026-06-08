<?php
session_start();

/*
    File: fullstack_jquerey_toutorial.php
    Single-file jQuery tutorial website for beginners
    Stack: PHP + HTML + Bootstrap + CSS + jQuery + JavaScript

    Features:
    - Responsive beginner tutorial website
    - PHP-generated lessons
    - Working jQuery interactions
    - Working AJAX demo endpoint in the same file
    - Working contact form handler
    - Quiz interaction
*/

$siteTitle = "jQuery Tutorial for Beginners";
$today = date("F j, Y");

$lessons = [
    [
        "title" => "What is jQuery?",
        "icon" => "⚡",
        "text" => "jQuery is a JavaScript library that makes DOM manipulation, events, animations, and AJAX easier."
    ],
    [
        "title" => "Selectors",
        "icon" => "🎯",
        "text" => 'Use selectors like $("#id"), $(".class"), $("p"), and $("div") to target elements.'
    ],
    [
        "title" => "Events",
        "icon" => "🖱️",
        "text" => "Common events include click, hover, input, submit, scroll, and keyup."
    ],
    [
        "title" => "Effects",
        "icon" => "✨",
        "text" => "Use hide(), show(), fadeIn(), fadeOut(), slideUp(), and slideToggle() for simple animations."
    ],
    [
        "title" => "DOM Manipulation",
        "icon" => "🧩",
        "text" => "Change content with text(), html(), append(), prepend(), remove(), and attr()."
    ],
    [
        "title" => "AJAX",
        "icon" => "🌐",
        "text" => "Load data without refreshing the page using $.get(), $.post(), and $.ajax()."
    ]
];

$quiz = [
    [
        "q" => "Which jQuery method waits for the page to load?",
        "options" => ["$(window).start()", "$(document).ready()", "$.readyPage()", "loadPage()"],
        "answer" => 1
    ],
    [
        "q" => "Which selector targets an element with id='menu'?",
        "options" => ['$(".menu")', '$("#menu")', '$("menu")', '$("[menu]")'],
        "answer" => 1
    ],
    [
        "q" => "Which method hides an element?",
        "options" => [".fadeOut()", ".hide()", ".remove()", ".slideDown()"],
        "answer" => 1
    ]
];

$contactSuccess = "";
$contactError = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["contact_submit"])) {
    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $message = trim($_POST["message"] ?? "");

    if ($name === "" || $email === "" || $message === "") {
        $contactError = "Please fill in all contact fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $contactError = "Please enter a valid email address.";
    } else {
        $contactSuccess = "Thanks, " . htmlspecialchars($name) . ". Your message has been received.";
    }
}

if (isset($_GET["action"]) && $_GET["action"] === "ajax-demo") {
    header("Content-Type: application/json; charset=utf-8");

    $payload = [
        "status" => "success",
        "title" => "AJAX Response",
        "message" => "This content came from the same PHP file through an AJAX request.",
        "serverTime" => date("H:i:s"),
        "date" => date("Y-m-d")
    ];

    echo json_encode($payload);
    exit;
}

$searchQuery = trim($_GET["search"] ?? "");
$filteredLessons = $lessons;

if ($searchQuery !== "") {
    $filteredLessons = array_values(array_filter($lessons, function ($lesson) use ($searchQuery) {
        return stripos($lesson["title"], $searchQuery) !== false || stripos($lesson["text"], $searchQuery) !== false;
    }));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($siteTitle); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --bg: #f8fafc;
            --ink: #0f172a;
            --muted: #475569;
            --brand: #2563eb;
            --brand2: #7c3aed;
            --card: #ffffff;
            --soft: #e2e8f0;
            --radius: 20px;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            background: var(--bg);
            color: var(--ink);
            font-family: Arial, Helvetica, sans-serif;
        }

        .navbar {
            backdrop-filter: blur(10px);
        }

        .hero {
            background: linear-gradient(135deg, var(--brand), var(--brand2));
            color: white;
            padding: 96px 0 84px;
        }

        .hero .badge {
            background: rgba(255,255,255,0.18);
            border: 1px solid rgba(255,255,255,0.22);
        }

        .section-title {
            font-weight: 800;
            letter-spacing: -0.02em;
        }

        .subtle {
            color: var(--muted);
        }

        .soft-card {
            background: var(--card);
            border: 1px solid rgba(15, 23, 42, 0.06);
            border-radius: var(--radius);
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.05);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            height: 100%;
        }

        .soft-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 16px 40px rgba(15, 23, 42, 0.08);
        }

        .code-box {
            background: #0b1220;
            color: #dbeafe;
            border-radius: 16px;
            padding: 18px;
            overflow-x: auto;
            font-family: Consolas, Monaco, "Courier New", monospace;
            font-size: 0.94rem;
            line-height: 1.6;
        }

        .demo-area {
            border: 1px dashed #cbd5e1;
            border-radius: 18px;
            background: #fff;
            padding: 22px;
        }

        .pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border-radius: 999px;
            padding: 0.55rem 0.9rem;
            background: #e0e7ff;
            color: #3730a3;
            font-weight: 600;
            font-size: 0.92rem;
        }

        .mini {
            font-size: 0.92rem;
            color: var(--muted);
        }

        .footer {
            background: #0f172a;
            color: #cbd5e1;
        }

        .form-control, .form-select {
            border-radius: 14px;
        }

        .btn {
            border-radius: 14px;
        }

        .lesson-icon {
            font-size: 1.5rem;
        }

        .tab-content {
            background: white;
            border: 1px solid #e2e8f0;
            border-top: 0;
            border-bottom-left-radius: 18px;
            border-bottom-right-radius: 18px;
            padding: 22px;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#home">jQuery Tutorial</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto gap-lg-2">
                <li class="nav-item"><a class="nav-link" href="#lessons">Lessons</a></li>
                <li class="nav-item"><a class="nav-link" href="#syntax">Syntax</a></li>
                <li class="nav-item"><a class="nav-link" href="#playground">Playground</a></li>
                <li class="nav-item"><a class="nav-link" href="#topics">Topics</a></li>
                <li class="nav-item"><a class="nav-link" href="#quiz">Quiz</a></li>
                <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
            </ul>
        </div>
    </div>
</nav>

<header id="home" class="hero">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <span class="badge rounded-pill mb-3">Beginner-friendly • PHP + jQuery + Bootstrap</span>
                <h1 class="display-4 fw-bold mb-3">Learn jQuery the right way</h1>
                <p class="lead mb-4">
                    A clean single-file website built for beginners. It includes real jQuery examples,
                    PHP form handling, AJAX, quiz logic, and responsive design.
                </p>
                <div class="d-flex flex-wrap gap-2">
                    <a href="#lessons" class="btn btn-light btn-lg">Start Learning</a>
                    <a href="#playground" class="btn btn-outline-light btn-lg">Try the Demo</a>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="soft-card p-4 bg-white text-dark">
                    <div class="pill mb-3">Today: <?php echo $today; ?></div>
                    <h5 class="fw-bold">What this page teaches</h5>
                    <p class="mini mb-0">
                        selectors, events, effects, DOM manipulation, AJAX, and simple PHP-backed interactivity.
                    </p>
                    <hr>
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="p-3 rounded-4 bg-light">
                                <div class="fw-bold">8+</div>
                                <div class="mini">examples</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 rounded-4 bg-light">
                                <div class="fw-bold">1 file</div>
                                <div class="mini">easy setup</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<main class="py-5">
    <section id="lessons" class="container mb-5">
        <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
            <div>
                <h2 class="section-title mb-2">Core lessons</h2>
                <p class="subtle mb-0">Simple explanations. No filler.</p>
            </div>
            <form class="d-flex gap-2" method="get" action="#lessons">
                <input type="text" name="search" class="form-control" placeholder="Search lessons..." value="<?php echo htmlspecialchars($searchQuery); ?>">
                <button class="btn btn-primary" type="submit">Search</button>
            </form>
        </div>

        <?php if ($searchQuery !== "" && count($filteredLessons) === 0): ?>
            <div class="alert alert-warning">No lesson matched your search.</div>
        <?php endif; ?>

        <div class="row g-4">
            <?php foreach ($filteredLessons as $lesson): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="soft-card p-4">
                        <div class="lesson-icon mb-3"><?php echo $lesson["icon"]; ?></div>
                        <h5 class="fw-bold"><?php echo htmlspecialchars($lesson["title"]); ?></h5>
                        <p class="mini mb-0"><?php echo htmlspecialchars($lesson["text"]); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section id="syntax" class="container mb-5">
        <div class="row g-4 align-items-start">
            <div class="col-lg-6">
                <h2 class="section-title mb-3">Basic jQuery syntax</h2>
                <p class="subtle">
                    The pattern is simple: select an element, then run an action on it.
                </p>
                <div class="code-box">
$(document).ready(function() {
    $("#btnToggle").click(function() {
        $("#messageBox").fadeToggle();
    });
});
                </div>
            </div>
            <div class="col-lg-6">
                <div class="soft-card p-4">
                    <h5 class="fw-bold mb-3">How it works</h5>
                    <ul class="mb-0">
                        <li><code>$(document).ready()</code> waits until the page is loaded.</li>
                        <li><code>$("#btnToggle")</code> finds the button by id.</li>
                        <li><code>.click()</code> listens for a click.</li>
                        <li><code>.fadeToggle()</code> shows or hides the box.</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section id="playground" class="container mb-5">
        <h2 class="section-title mb-3">Working playground</h2>
        <p class="subtle mb-4">These buttons actually do something.</p>

        <div class="demo-area">
            <div class="row g-3">
                <div class="col-lg-4">
                    <button id="btnToggle" class="btn btn-primary w-100 mb-3">Toggle Message</button>
                    <button id="btnChangeText" class="btn btn-success w-100 mb-3">Change Text</button>
                    <button id="btnAddItem" class="btn btn-dark w-100 mb-3">Add List Item</button>
                </div>

                <div class="col-lg-8">
                    <div id="messageBox" class="alert alert-success">
                        This box will fade in and out using jQuery.
                    </div>

                    <div id="textTarget" class="soft-card p-3 mb-3">
                        This text will change when the button is clicked.
                    </div>

                    <ul id="listTarget" class="list-group mb-3">
                        <li class="list-group-item">First item</li>
                        <li class="list-group-item">Second item</li>
                    </ul>

                    <div class="soft-card p-3">
                        <div class="mini mb-1">Hover demo</div>
                        <div id="hoverTarget" class="p-3 rounded-4 bg-light">
                            Hover over this box to change its appearance.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container mb-5">
        <div class="row g-4">
            <div class="col-lg-6">
                <h2 class="section-title mb-3">AJAX example</h2>
                <p class="subtle">This uses the same PHP file as a JSON endpoint.</p>
                <button id="ajaxBtn" class="btn btn-outline-primary mb-3">Load AJAX content</button>
                <div id="ajaxResult" class="soft-card p-4">
                    Click the button to load content from the server.
                </div>
            </div>

            <div class="col-lg-6">
                <h2 class="section-title mb-3">Clean code example</h2>
                <div class="code-box">
$("#ajaxBtn").click(function() {
    $.get("?action=ajax-demo", function(response) {
        $("#ajaxResult").html(response.message);
    });
});
                </div>
            </div>
        </div>
    </section>

    <section id="topics" class="container mb-5">
        <h2 class="section-title mb-3">Main topics</h2>
        <div class="soft-card p-3 p-md-4">
            <ul class="nav nav-pills gap-2 mb-3" id="topicTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tabSelectors" type="button">Selectors</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabEvents" type="button">Events</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabEffects" type="button">Effects</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabAjax" type="button">AJAX</button>
                </li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane fade show active" id="tabSelectors">
                    <h5 class="fw-bold">Selectors</h5>
                    <p class="mb-0">Use selectors to choose HTML elements: ids, classes, tags, attributes, and more.</p>
                </div>
                <div class="tab-pane fade" id="tabEvents">
                    <h5 class="fw-bold">Events</h5>
                    <p class="mb-0">Events respond to user actions like click, change, submit, and hover.</p>
                </div>
                <div class="tab-pane fade" id="tabEffects">
                    <h5 class="fw-bold">Effects</h5>
                    <p class="mb-0">Effects are useful for showing, hiding, fading, sliding, and animating elements.</p>
                </div>
                <div class="tab-pane fade" id="tabAjax">
                    <h5 class="fw-bold">AJAX</h5>
                    <p class="mb-0">AJAX loads data from the server without refreshing the page.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="quiz" class="container mb-5">
        <h2 class="section-title mb-3">Mini quiz</h2>
        <div class="row g-4">
            <?php foreach ($quiz as $index => $item): ?>
                <div class="col-lg-4">
                    <div class="soft-card p-4 quiz-card" data-answer="<?php echo $item["answer"]; ?>" data-index="<?php echo $index; ?>">
                        <div class="fw-bold mb-3">Question <?php echo $index + 1; ?></div>
                        <p><?php echo htmlspecialchars($item["q"]); ?></p>
                        <div class="d-grid gap-2">
                            <?php foreach ($item["options"] as $optIndex => $opt): ?>
                                <button type="button" class="btn btn-outline-primary quiz-option" data-option="<?php echo $optIndex; ?>">
                                    <?php echo htmlspecialchars($opt); ?>
                                </button>
                            <?php endforeach; ?>
                        </div>
                        <div class="quiz-feedback mt-3 small"></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section id="contact" class="container mb-5">
        <div class="row g-4">
            <div class="col-lg-6">
                <h2 class="section-title mb-3">Contact form</h2>
                <p class="subtle">This is handled by PHP on the same file.</p>

                <?php if ($contactSuccess !== ""): ?>
                    <div class="alert alert-success"><?php echo htmlspecialchars($contactSuccess); ?></div>
                <?php endif; ?>

                <?php if ($contactError !== ""): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($contactError); ?></div>
                <?php endif; ?>

                <form method="post" class="soft-card p-4">
                    <input type="hidden" name="contact_submit" value="1">

                    <div class="mb-3">
                        <label class="form-label">Your name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter your name">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Your email</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter your email">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Message</label>
                        <textarea name="message" class="form-control" rows="5" placeholder="Write your message"></textarea>
                    </div>

                    <button class="btn btn-primary" type="submit">Send message</button>
                </form>
            </div>

            <div class="col-lg-6">
                <h2 class="section-title mb-3">What to practice next</h2>
                <div class="soft-card p-4">
                    <div class="d-flex flex-column gap-3">
                        <div class="p-3 rounded-4 bg-light">
                            Try changing text with <code>.text()</code>
                        </div>
                        <div class="p-3 rounded-4 bg-light">
                            Try adding HTML with <code>.html()</code>
                        </div>
                        <div class="p-3 rounded-4 bg-light">
                            Try toggling elements with <code>.slideToggle()</code>
                        </div>
                        <div class="p-3 rounded-4 bg-light">
                            Try sending data with <code>$.get()</code>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<footer class="footer py-4">
    <div class="container text-center">
        <div class="fw-semibold">jQuery Tutorial for Beginners</div>
        <div class="small">Single-file build using PHP, Bootstrap, CSS, JavaScript, and jQuery.</div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$(function() {
    $("#btnToggle").on("click", function() {
        $("#messageBox").fadeToggle(200);
    });

    $("#btnChangeText").on("click", function() {
        $("#textTarget").text("The text changed successfully using jQuery .text().");
    });

    $("#btnAddItem").on("click", function() {
        const count = $("#listTarget li").length + 1;
        $("#listTarget").append('<li class="list-group-item">Dynamic item ' + count + '</li>');
    });

    $("#hoverTarget").on("mouseenter", function() {
        $(this).css({
            background: "#dbeafe",
            color: "#1e3a8a",
            fontWeight: "600"
        });
    });

    $("#hoverTarget").on("mouseleave", function() {
        $(this).css({
            background: "#f8fafc",
            color: "",
            fontWeight: ""
        });
    });

    $("#ajaxBtn").on("click", function() {
        const btn = $(this);
        btn.prop("disabled", true).text("Loading...");

        $.get("?action=ajax-demo", function(response) {
            $("#ajaxResult").html(
                '<div class="alert alert-info mb-0">' +
                '<strong>' + response.title + ':</strong> ' +
                response.message +
                '<br><small>Server time: ' + response.serverTime + ' | Date: ' + response.date + '</small>' +
                '</div>'
            );
        }, "json").fail(function() {
            $("#ajaxResult").html('<div class="alert alert-danger mb-0">AJAX request failed.</div>');
        }).always(function() {
            btn.prop("disabled", false).text("Load AJAX content");
        });
    });

    $(".quiz-option").on("click", function() {
        const card = $(this).closest(".quiz-card");
        const selected = parseInt($(this).data("option"), 10);
        const answer = parseInt(card.data("answer"), 10);
        const feedback = card.find(".quiz-feedback");

        card.find(".quiz-option").removeClass("btn-success btn-danger").addClass("btn-outline-primary");

        if (selected === answer) {
            $(this).removeClass("btn-outline-primary").addClass("btn-success");
            feedback.html('<span class="text-success fw-semibold">Correct.</span>');
        } else {
            $(this).removeClass("btn-outline-primary").addClass("btn-danger");
            card.find('.quiz-option[data-option="' + answer + '"]').removeClass("btn-outline-primary").addClass("btn-success");
            feedback.html('<span class="text-danger fw-semibold">Wrong. The correct answer is highlighted.</span>');
        }

        card.find(".quiz-option").prop("disabled", true);
    });
});
</script>
</body>
</html>