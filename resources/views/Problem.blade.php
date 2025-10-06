<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
  <title>Problem • CodeQuest</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    :root{
      --bg:#fbfdff;--card:#fff;--text:#0b2540;--muted:#5b6b77;--accent:#0d6efd
    }
    body{background:var(--bg);color:var(--text);font-family:Inter,system-ui,Segoe UI,Roboto,Arial;margin:0}
    .wrap{max-width:780px;margin:36px auto;padding:16px}
    .card{background:var(--card);border-radius:10px;padding:18px;box-shadow:0 6px 18px rgba(11,37,64,0.06);border:1px solid rgba(11,37,64,0.04)}
    .label{color:var(--muted);font-size:.9rem;margin:0}
    .value{font-weight:600;margin:6px 0 14px}
    .tag{display:inline-block;padding:6px 10px;border-radius:999px;background:rgba(13,110,253,0.08);color:var(--accent);font-weight:600}
    a.btn-ghost{border:1px solid rgba(11,37,64,0.06);background:transparent;color:var(--text)}
  </style>
</head>
<body>
  <div class="wrap">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <div class="d-flex align-items-center gap-2">
        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" aria-hidden>
          <rect width="24" height="24" rx="6" fill="#0d6efd" opacity="0.12"></rect>
          <path d="M7 8h10M7 12h10M7 16h6" stroke="#0d6efd" stroke-width="1.5" stroke-linecap="round"></path>
        </svg>
        <h4 class="m-0">Problem Details</h4>
      </div>

      <div class="d-flex align-items-center gap-2">
        <a href="/" class="btn btn-sm btn-ghost">Back</a>
        <span class="tag">{{ $problem_no }}</span>
      </div>
    </div>

    <div class="card">
      <p class="label">Title</p>
      <div class="value">{{ $problem }}</div>

      <p class="label">Tag</p>
      <div class="value"><span class="tag">{{ $tag }}</span></div>
      <!-- Problem No moved to header; removed duplicate display here -->
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>