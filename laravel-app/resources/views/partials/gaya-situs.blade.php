<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
:root{--p:#5b3df5;--p-d:#4527d8;--p-l:#ede9ff;--bg:#f7f6ff;--tx:#161432;--mu:#6b6a85;--bd:#ebe9f7;--ok:#0f9d6b;--ok-l:#dcf6ec}
*{box-sizing:border-box}html{scroll-behavior:smooth}
body{margin:0;font-family:'Plus Jakarta Sans',system-ui,sans-serif;background:var(--bg);color:var(--tx);font-size:14px;line-height:1.55}
a{color:inherit;text-decoration:none}h1,h2,h3,h4,p{margin:0}
.wrap{max-width:1180px;margin:0 auto;padding:0 28px}
/* navbar */
.nav{position:sticky;top:0;z-index:20;background:rgba(255,255,255,.85);backdrop-filter:blur(10px);border-bottom:1px solid var(--bd)}
.nav .wrap{display:flex;align-items:center;gap:28px;height:68px}
.brand{display:flex;align-items:center;gap:10px;font-weight:800;font-size:18px;line-height:1.1}.brand b{color:var(--p)}
.brand i{width:38px;height:38px;border-radius:11px;background:var(--p);display:grid;place-items:center;color:#fff;font-style:normal;font-size:16px}
.brand small{display:block;font-size:9px;font-weight:600;color:var(--mu);letter-spacing:.07em}
.menu{display:flex;gap:6px}.menu a{padding:8px 14px;border-radius:10px;font-weight:600;color:#3a3858}.menu a.on{background:var(--p-l);color:var(--p-d)}
.nav .kanan{margin-left:auto;display:flex;align-items:center;gap:16px}
.btn{display:inline-flex;align-items:center;justify-content:center;gap:6px;border:0;cursor:pointer;font:inherit;font-weight:700;padding:11px 22px;border-radius:999px;background:var(--p);color:#fff;font-size:13px;box-shadow:0 8px 20px -8px rgba(91,61,245,.7)}
.btn:hover{background:var(--p-d)}.btn.soft{background:var(--p-l);color:var(--p-d);box-shadow:none}.btn.sm{padding:9px 16px;font-size:12.5px}.btn.putih{background:#fff;color:var(--p-d);box-shadow:none}
.ava{width:36px;height:36px;border-radius:50%;background:var(--p-l);color:var(--p);display:grid;place-items:center;font-weight:800}
.flash{margin:16px 0 0;padding:12px 16px;border-radius:12px;font-weight:600}.flash.ok{background:var(--ok-l);color:var(--ok)}.flash.er{background:#fde4e4;color:#dc2626}
/* hero beranda */
.hero{display:grid;grid-template-columns:1.1fr 1fr;gap:48px;align-items:center;padding:64px 0 56px}
.hero h1{font-size:46px;line-height:1.1;font-weight:800;letter-spacing:-.03em}.hero h1 span{color:var(--p)}
.hero p.lead{color:var(--mu);font-size:15.5px;margin:22px 0 26px;max-width:520px}
.stat3{display:inline-flex;gap:34px;background:#fff;border:1px solid var(--bd);border-radius:20px;padding:20px 28px;margin-top:30px}
.stat3 strong{display:block;font-size:24px;font-weight:800;color:var(--tx)}.stat3 div:nth-child(2) strong{color:var(--p)}.stat3 div:nth-child(3) strong{color:var(--ok)}
.stat3 small{font-size:10.5px;font-weight:700;letter-spacing:.06em;color:var(--mu);text-transform:uppercase}
.sorot{background:#fff;border:1px solid var(--bd);border-radius:26px;padding:22px;box-shadow:0 30px 60px -30px rgba(91,61,245,.35)}
.mini{display:flex;align-items:center;gap:12px}.mini .av{width:42px;height:42px}
.av{border-radius:50%;background:var(--p-l);color:var(--p);display:grid;place-items:center;font-weight:800;flex:none}
.badge-ok{margin-left:auto;background:var(--ok-l);color:var(--ok);font-size:11px;font-weight:700;padding:4px 10px;border-radius:999px;white-space:nowrap}
.gbr{position:relative;border-radius:16px;overflow:hidden;background:linear-gradient(135deg,#6d52ff,#2f1fb0);aspect-ratio:16/8.5;margin:16px 0}
.gbr img{width:100%;height:100%;object-fit:cover;display:block}
.gbr .cap{position:absolute;inset:auto 0 0 0;padding:34px 14px 12px;color:#fff;font-weight:700;background:linear-gradient(transparent,rgba(10,8,40,.78))}
.gbr .cap small{display:inline-block;background:var(--p);padding:2px 8px;border-radius:6px;font-size:10px;margin-bottom:4px}
.gbr .kosong{display:grid;place-items:center;height:100%;color:rgba(255,255,255,.5);font-size:34px;font-weight:800}
.info{background:var(--p-l);border-radius:12px;padding:10px 14px;font-weight:600;font-size:12.5px;display:flex;justify-content:space-between;gap:10px;color:var(--p-d)}
/* seksi */
.eyebrow{display:inline-block;background:var(--p-l);color:var(--p);font-size:10.5px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;padding:4px 10px;border-radius:999px}
.seksi{padding:56px 0}.seksi h2{font-size:30px;font-weight:800;letter-spacing:-.02em;margin-top:12px}
.sh{display:flex;justify-content:space-between;align-items:flex-end;gap:24px;flex-wrap:wrap;margin-bottom:34px}.sh p{color:var(--mu);max-width:420px}
.fitur{display:grid;grid-template-columns:1fr 240px 1fr;gap:28px;align-items:center}
.fitur .kartu{background:#fff;border:1px solid var(--bd);border-radius:24px;padding:30px;min-height:290px;display:flex;flex-direction:column}
.fitur .ik{width:46px;height:46px;border-radius:14px;display:grid;place-items:center;font-size:20px;margin-bottom:18px}
.fitur h3{font-size:20px;font-weight:800;margin-bottom:10px}.fitur p{color:var(--mu)}
.fitur .bawah{margin-top:auto;background:var(--bg);border-radius:14px;padding:12px 16px;display:flex;justify-content:space-between;font-weight:600;font-size:12.5px}
.fitur img.mk{width:100%;display:block}
/* kartu portofolio */
.grid3{display:grid;grid-template-columns:repeat(3,1fr);gap:22px}
.pk{background:#fff;border:1px solid var(--bd);border-radius:24px;padding:20px;display:flex;flex-direction:column;gap:12px;transition:.2s}.pk:hover{box-shadow:0 24px 40px -24px rgba(91,61,245,.4);transform:translateY(-2px)}
.pk .gbr{margin:0}.pk .gbr .cap{font-size:13px}
.pk .tag{position:absolute;top:10px;left:10px;background:#fff;color:var(--p-d);font-size:10.5px;font-weight:700;padding:3px 10px;border-radius:999px;z-index:2}
.pk .tag.r{left:auto;right:10px;background:var(--ok-l);color:var(--ok)}
.pk h3{font-size:16px;font-weight:700;line-height:1.35}.pk .ds{color:var(--mu);font-size:13px}
.pk .nm{font-weight:700}.pk .sub{color:var(--mu);font-size:12px}
.tags{display:flex;gap:6px;flex-wrap:wrap}.tags span{background:var(--p-l);color:var(--p-d);font-size:11.5px;font-weight:600;padding:4px 10px;border-radius:8px}
.pk .kaki{margin-top:auto;display:flex;justify-content:space-between;align-items:center;gap:8px;padding-top:10px}.pk .kaki small{color:var(--mu);font-weight:600}
.dua{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-top:4px}
.stripe{background:var(--bg);border-radius:12px;padding:10px 14px;display:flex;justify-content:space-between;font-size:12.5px;font-weight:600;color:var(--mu)}.stripe b{color:var(--tx)}
.kosong-s{background:#fff;border:1px dashed #cfc9f3;border-radius:22px;padding:48px;text-align:center;color:var(--mu);grid-column:1/-1}
/* banner mentor */
.banner{background:linear-gradient(120deg,#3b22d8,#6a4dff);color:#fff;border-radius:28px;padding:48px;display:grid;grid-template-columns:1.4fr 1fr;gap:36px;align-items:center}
.banner h2{font-size:30px;line-height:1.2;margin:14px 0}.banner p{opacity:.85;margin-bottom:18px}.banner .eyebrow{background:rgba(255,255,255,.16);color:#fff}
.banner ul{display:flex;gap:18px;flex-wrap:wrap;padding:0;margin:0;list-style:none;font-weight:600;font-size:12.5px}.banner li::before{content:"✓ ";color:#7ef0c0}
.banner .aksi{display:flex;flex-direction:column;align-items:center;gap:16px}.banner .aksi .btn{padding:15px 36px;font-size:14px}
/* katalog */
.khero{display:grid;grid-template-columns:1.2fr auto auto;gap:28px;align-items:center;padding:56px 0 30px}
.khero h1{font-size:44px;line-height:1.08;font-weight:800;letter-spacing:-.03em}.khero h1 span{color:var(--p)}.khero p{color:var(--mu);max-width:430px;margin-top:16px}
.khero .mkbox{width:170px;height:170px;border-radius:34px;background:linear-gradient(160deg,#cfc6ff,#9a85ff);display:grid;place-items:center;overflow:hidden}.khero .mkbox img{width:100%}
.khero .stat3{margin:0;padding:16px 24px;gap:26px}
.filter{background:#fff;border:1px solid var(--bd);border-radius:26px;padding:26px;margin-bottom:34px}
.frow{display:grid;grid-template-columns:1fr 230px 230px;gap:14px}
.fi{font:inherit;border:0;background:var(--bg);border-radius:14px;padding:14px 18px;width:100%;color:var(--tx);font-weight:500}.fi:focus{outline:2px solid var(--p)}
.chips{display:flex;gap:8px;flex-wrap:wrap;align-items:center;margin-top:16px}.chips>span{color:var(--mu);font-weight:600;margin-right:4px}
.chips a{padding:6px 14px;border-radius:999px;background:var(--bg);font-weight:600;font-size:12.5px;color:#3a3858}.chips a.on{background:var(--p);color:#fff}
.chips .reset{margin-left:auto;background:none;color:var(--mu)}
.jud{display:flex;justify-content:space-between;align-items:center;margin-bottom:18px;flex-wrap:wrap;gap:8px}.jud h2{font-size:21px;font-weight:800}.jud h2 em{font-style:normal;background:var(--p-l);color:var(--p);font-size:12px;padding:3px 10px;border-radius:999px;margin-left:8px;vertical-align:middle}
.pk.m .bd{color:var(--p);font-size:11px;font-weight:700;letter-spacing:.06em;text-transform:uppercase}
.pag{display:flex;justify-content:space-between;align-items:center;margin:38px 0 60px;flex-wrap:wrap;gap:12px;color:var(--mu)}
.pag nav{display:flex;gap:6px;align-items:center}.pag nav a,.pag nav span{min-width:36px;height:36px;padding:0 12px;border-radius:999px;display:grid;place-items:center;font-weight:600;background:#fff;border:1px solid var(--bd)}
.pag nav a.on{background:var(--p);color:#fff;border-color:var(--p)}.pag nav span.mati{opacity:.45}
/* footer */
.foot{background:#fff;border-top:1px solid var(--bd);margin-top:40px;padding:56px 0 28px}
.foot .g{display:grid;grid-template-columns:1.6fr 1fr 1fr 1fr;gap:32px}
.foot h4{font-size:14px;font-weight:800;margin-bottom:14px}.foot li{list-style:none;margin-bottom:10px;color:var(--mu);font-size:13px}.foot ul{padding:0;margin:0}
.foot .about p{color:var(--mu);margin:16px 0}.foot .sdg{display:inline-block;background:var(--ok-l);color:var(--ok);font-weight:700;font-size:12px;padding:8px 14px;border-radius:999px}
.foot .cp{display:flex;justify-content:space-between;margin-top:44px;color:var(--mu);font-size:12px;font-weight:600;flex-wrap:wrap;gap:8px}
@media(max-width:900px){.hero,.fitur,.banner,.khero,.frow,.foot .g{grid-template-columns:1fr}.grid3{grid-template-columns:1fr}.menu{display:none}.hero h1,.khero h1{font-size:34px}.fitur img.mk{max-width:200px;margin:auto}.khero .mkbox{display:none}}
@media(min-width:901px) and (max-width:1100px){.grid3{grid-template-columns:repeat(2,1fr)}}
</style>
