<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
:root{--p:#5b3df5;--p-d:#4527d8;--p-l:#ede9ff;--bg:#f7f6ff;--card:#fff;--tx:#161432;--mu:#6b6a85;--bd:#ebe9f7;--ok:#0f9d6b;--ok-l:#dcf6ec;--wr:#d97706;--wr-l:#fff1d6;--er:#dc2626;--er-l:#fde4e4;--gr-l:#eceaf5}
*{box-sizing:border-box}body{margin:0;font-family:'Plus Jakarta Sans',system-ui,sans-serif;background:var(--bg);color:var(--tx);font-size:14px;line-height:1.5}
a{color:inherit;text-decoration:none}h1,h2,h3,p{margin:0}
.app{display:grid;grid-template-columns:240px 1fr;min-height:100vh}
.side{background:var(--card);border-right:1px solid var(--bd);padding:24px 16px;display:flex;flex-direction:column;position:sticky;top:0;height:100vh}
.brand{display:flex;align-items:center;gap:10px;font-weight:800;font-size:18px;margin-bottom:28px}.brand b{color:var(--p)}
.brand i{width:36px;height:36px;border-radius:10px;background:var(--p);display:grid;place-items:center;color:#fff;font-style:normal}
.brand small{display:block;font-size:10px;font-weight:600;color:var(--mu);letter-spacing:.06em}
.side h6{margin:0 0 8px 8px;font-size:11px;letter-spacing:.08em;color:var(--mu);font-weight:600}
.side nav a{display:block;padding:10px 12px;border-radius:10px;color:var(--mu);font-weight:500;margin-bottom:2px}
.side nav a.on{background:var(--p-l);color:var(--p-d);font-weight:700;border:1px solid #d9d2ff}
.side .out{margin-top:auto}.side .out button{all:unset;cursor:pointer;color:var(--mu);padding:10px 12px;font-weight:500}
.main{min-width:0}.top{display:flex;justify-content:space-between;align-items:center;padding:16px 32px;background:var(--card);border-bottom:1px solid var(--bd)}
.who{text-align:right;font-weight:700;line-height:1.2}.who small{display:block;color:var(--p);font-weight:600;font-size:12px}
.av{width:36px;height:36px;border-radius:50%;background:var(--p-l);color:var(--p);display:inline-grid;place-items:center;font-weight:800;font-size:13px;flex:none;overflow:hidden}
.page{padding:28px 32px;max-width:1180px}.eyebrow{font-size:11px;font-weight:700;letter-spacing:.1em;color:var(--p);text-transform:uppercase}
.head{display:flex;justify-content:space-between;align-items:flex-end;gap:16px;margin-bottom:22px;flex-wrap:wrap}
.head h1{font-size:30px;font-weight:800;letter-spacing:-.02em}.head p{color:var(--mu);max-width:560px;margin-top:6px}
.btn{display:inline-flex;align-items:center;justify-content:center;gap:6px;border:0;cursor:pointer;font:inherit;font-weight:700;padding:10px 18px;border-radius:999px;background:var(--p);color:#fff;font-size:13px}
.btn:hover{background:var(--p-d)}.btn.soft{background:var(--p-l);color:var(--p-d)}.btn.ok{background:var(--ok)}.btn.bad{background:var(--er-l);color:var(--er)}.btn.sm{padding:6px 12px;font-size:12px}
.card{background:var(--card);border:1px solid var(--bd);border-radius:20px;padding:22px}
.stats{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:22px}
.stat small{display:block;font-size:11px;font-weight:700;letter-spacing:.06em;color:var(--mu);text-transform:uppercase}.stat strong{font-size:30px;font-weight:800}.stat span{color:var(--mu);font-size:12px;margin-left:6px}
.tabs{display:inline-flex;background:var(--gr-l);border-radius:999px;padding:4px;gap:2px;flex-wrap:wrap}
.tabs button{border:0;background:none;font:inherit;font-weight:600;color:var(--mu);padding:8px 16px;border-radius:999px;cursor:pointer}.tabs button.on{background:var(--p);color:#fff}
.bar{display:flex;justify-content:space-between;gap:12px;align-items:center;margin-bottom:16px;flex-wrap:wrap}
.bar input{font:inherit;border:1px solid var(--bd);background:#fff;border-radius:999px;padding:9px 16px;min-width:220px}
.chip{display:inline-block;font-size:11px;font-weight:700;padding:3px 10px;border-radius:999px;background:var(--p-l);color:var(--p-d)}
.chip.ok{background:var(--ok-l);color:var(--ok)}.chip.wr{background:var(--wr-l);color:var(--wr)}.chip.er{background:var(--er-l);color:var(--er)}.chip.gr{background:var(--gr-l);color:var(--mu)}
.flash{padding:12px 16px;border-radius:12px;margin-bottom:18px;font-weight:600}.flash.ok{background:var(--ok-l);color:var(--ok)}.flash.er{background:var(--er-l);color:var(--er)}
.row{display:flex;align-items:center;gap:20px;padding:18px 22px;border-top:1px solid var(--bd)}.row:first-child{border-top:0}
.th{width:112px;height:96px;border-radius:12px;object-fit:cover;background:var(--p-l);flex:none}
.row .info{flex:1;min-width:0}.row h3{font-size:16px;font-weight:700;display:inline}.meta{color:var(--mu);font-size:13px;margin:4px 0}.meta b{color:var(--tx)}
.acts{display:flex;gap:8px;flex:none;flex-wrap:wrap}.acts form{margin:0}
table{width:100%;border-collapse:collapse}th{font-size:11px;letter-spacing:.06em;text-transform:uppercase;color:var(--mu);text-align:left;padding:12px 14px;background:#f3f1fd}
td{padding:14px;border-top:1px solid var(--bd);vertical-align:middle}td small{display:block;color:var(--mu)}
.mono{font-family:ui-monospace,Menlo,monospace;font-size:12px}
.cal{display:grid;grid-template-columns:repeat(7,1fr);gap:8px;text-align:center}.cal .dh{font-size:12px;font-weight:700;color:var(--mu)}.cal .dh:first-child{color:var(--er)}
.cal div.d{min-height:54px;border-radius:10px;background:#f6f5fb;color:#b6b4c9;padding:6px 2px;font-weight:600}.cal div.d small{display:block;font-size:10px;font-weight:700;margin:2px 6px 0}
.cal .tersedia{background:var(--ok-l);color:var(--ok);border:1px solid #a9e5cb}.cal .dipesan{background:var(--p-l);color:var(--p-d);border:1px solid #cfc6ff}.cal .ditutup{background:var(--gr-l);color:var(--mu)}
.legend{display:flex;gap:14px;font-size:12px;color:var(--mu)}.legend i{display:inline-block;width:8px;height:8px;border-radius:50%;margin-right:5px}
.grid2{display:grid;grid-template-columns:1fr 1.2fr;gap:20px}
.box{background:var(--p-l);border-radius:14px;padding:14px 16px;white-space:pre-line}.lbl{font-size:11px;font-weight:700;letter-spacing:.07em;color:var(--mu);text-transform:uppercase;margin:16px 0 8px}
.empty{padding:48px 16px;text-align:center;color:var(--mu)}.note{color:var(--mu);font-size:12px;margin-top:18px}.note.er{color:var(--er)}
/* form */
.fg{margin-bottom:18px}.fg>label{display:block;font-weight:700;margin-bottom:6px;font-size:13px}
.fg input[type=text],.fg input[type=url],.fg input[type=date],.fg input[type=time],.fg input[type=file],.fg select,.fg textarea{width:100%;font:inherit;border:1px solid var(--bd);border-radius:12px;padding:10px 14px;background:#fff}
.fg textarea{min-height:130px;resize:vertical}.fg .err{color:var(--er);font-size:12px;margin-top:4px}.fg .hint{color:var(--mu);font-size:12px;margin-top:4px}
.fg input:focus,.fg select:focus,.fg textarea:focus{outline:2px solid #cfc6ff;border-color:var(--p)}
.two{display:grid;grid-template-columns:1fr 1fr;gap:16px}.formcard{max-width:760px}
.checks{display:flex;flex-wrap:wrap;gap:8px}.checks label{cursor:pointer}.checks input{position:absolute;opacity:0}
.checks span{display:inline-block;padding:6px 14px;border-radius:999px;background:var(--gr-l);color:var(--mu);font-weight:600;font-size:13px;border:1px solid transparent}
.checks input:checked+span{background:var(--p-l);color:var(--p-d);border-color:#cfc6ff}.checks input:focus-visible+span{outline:2px solid var(--p)}
.preview{width:160px;height:110px;border-radius:12px;object-fit:cover;margin-bottom:8px;display:block}
.formact{display:flex;gap:10px;margin-top:8px}
/* publik */
.pnav{display:flex;justify-content:space-between;align-items:center;padding:14px 48px;background:#fff;border-bottom:1px solid var(--bd)}.pnav nav{display:flex;gap:26px;align-items:center}.pnav nav a.on{color:var(--p);font-weight:700;background:var(--p-l);padding:6px 14px;border-radius:10px}
.hero{padding:48px 48px 28px;background:linear-gradient(180deg,#e9e4ff,var(--bg))}.hero h1{font-size:40px;font-weight:800;line-height:1.1;letter-spacing:-.03em}.hero h1 span{color:var(--p)}.hero p{color:var(--mu);max-width:560px;margin-top:12px}
.pwrap{padding:0 48px 48px;max-width:1320px;margin:auto}.pwrap.narrow{max-width:960px}
.cards{display:grid;grid-template-columns:repeat(3,1fr);gap:24px}.pc{display:flex;flex-direction:column;gap:12px}
.pc .cat{font-size:11px;font-weight:700;letter-spacing:.06em;color:var(--p);text-transform:uppercase}.pc h3{font-size:18px;font-weight:700}.pc .cover{height:150px;border-radius:14px;object-fit:cover;width:100%;background:var(--p-l)}
.pc p{color:var(--mu);font-size:13px}.tags{display:flex;flex-wrap:wrap;gap:6px}.pc .btn{margin-top:auto}
.mhead{display:flex;gap:18px;align-items:center;flex-wrap:wrap}.mhead .av{width:72px;height:72px;font-size:26px;background:var(--p);color:#fff;border-radius:20px}
.cover-lg{width:100%;max-height:380px;object-fit:cover;border-radius:18px;margin-bottom:20px}.prose{white-space:pre-line;line-height:1.7}
.slotcard{display:flex;flex-direction:column;gap:10px}.slotcard summary{list-style:none;cursor:pointer}.slotcard summary::-webkit-details-marker{display:none}
.pfoot{background:#f1efff;padding:32px 48px;color:var(--mu);margin-top:40px;display:flex;justify-content:space-between;flex-wrap:wrap;gap:12px}
@media(max-width:900px){.app{grid-template-columns:1fr}.side{position:static;height:auto}.stats{grid-template-columns:1fr 1fr}.grid2,.two{grid-template-columns:1fr}.cards{grid-template-columns:1fr}.row{flex-wrap:wrap}.pnav,.hero,.pwrap{padding-left:20px;padding-right:20px}.page{padding:20px 16px}.hero h1{font-size:30px}.pnav nav{display:none}}
</style>