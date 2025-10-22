// Mobile Menu Toggle
const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
const mainNav = document.querySelector('.main-nav');

mobileMenuBtn.addEventListener('click', () => {
  mainNav.style.display = mainNav.style.display === 'block' ? 'none' : 'block';
});

// High Contrast Mode Toggle (optional element)
const highContrastBtn = document.getElementById('high-contrast-btn');
if (highContrastBtn) {
  highContrastBtn.addEventListener('click', () => {
    document.body.classList.toggle('high-contrast');
  });
}

// Font Size Toggle (optional element)
const fontSizeBtn = document.getElementById('font-size-btn');
if (fontSizeBtn) {
  fontSizeBtn.addEventListener('click', () => {
    const currentSize = parseFloat(getComputedStyle(document.body).fontSize);
    document.body.style.fontSize = (currentSize === 16) ? '18px' : '16px';
  });
}

// Cookie Consent (optional elements)
const cookieBanner = document.getElementById('cookie-banner');
const acceptCookiesBtn = document.getElementById('accept-cookies');
if (cookieBanner && acceptCookiesBtn) {
  if (!localStorage.getItem('cookiesAccepted')) {
    cookieBanner.style.display = 'flex';
  }
  acceptCookiesBtn.addEventListener('click', () => {
    localStorage.setItem('cookiesAccepted', 'true');
    cookieBanner.style.display = 'none';
  });
}

// Newsletter Form Submission (optional element)
const newsletterForm = document.getElementById('newsletter-form');
if (newsletterForm) {
  newsletterForm.addEventListener('submit', (e) => {
    e.preventDefault();
    const email = newsletterForm.querySelector('input').value;
    alert(`Thank you for subscribing with ${email}!`);
    newsletterForm.reset();
  });
}

// Live Chat Button (optional element)
const liveChatBtn = document.getElementById('live-chat-btn');
if (liveChatBtn) {
  liveChatBtn.addEventListener('click', () => {
    alert('Live chat support will open in a new window.');
  });
}

// Language Switcher (optional element)
const languageSelect = document.getElementById('language-select');
if (languageSelect) {
  languageSelect.addEventListener('change', () => {
    alert(`Language changed to ${languageSelect.value}. This would reload the page with translations.`);
  });
}

// Smooth Scrolling for Anchor Links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener('click', function(e) {
    e.preventDefault();
    document.querySelector(this.getAttribute('href')).scrollIntoView({
      behavior: 'smooth'
    });
  });
});

// Hero counters (count-up on load)
(function(){
  function animateCount(el, target, duration, done){
    const start = 0;
    const startTime = performance.now();
    function step(now){
      const p = Math.min(1, (now - startTime) / duration);
      const val = Math.floor(start + (target - start) * p);
      el.textContent = val;
      if (p < 1) requestAnimationFrame(step); else if (done) done();
    }
    requestAnimationFrame(step);
  }
  const users = document.querySelector('.user-counter');
  const care = document.querySelector('.care-counter');
  if (users) {
    const targetUsers = parseInt(users.getAttribute('data-target') || '1000', 10);
    animateCount(users, targetUsers, 1800, () => {
      if (!isNaN(targetUsers) && targetUsers >= 1000) users.textContent = `${targetUsers}+`;
    });
  }
  if (care) {
    const targetCare = parseInt(care.getAttribute('data-target') || '100', 10);
    animateCount(care, targetCare, 1600);
  }
})();

// Horizontal scroll controls for events and articles
(function(){
  function setupScroll(buttonLeftId, buttonRightId, containerSelector){
    const leftBtn = document.getElementById(buttonLeftId);
    const rightBtn = document.getElementById(buttonRightId);
    const container = document.querySelector(containerSelector);
    if (!container || !leftBtn || !rightBtn) return;
    const scrollAmount = 320; // roughly one card width
    leftBtn.addEventListener('click', () => container.scrollBy({ left: -scrollAmount, behavior: 'smooth' }));
    rightBtn.addEventListener('click', () => container.scrollBy({ left: scrollAmount, behavior: 'smooth' }));
  }
  setupScroll('events-left', 'events-right', '.events-grid');
  setupScroll('articles-left', 'articles-right', '.articles-container');
})();

// ===== Registration & Dashboard Flow =====
// Safe navigation from header Register button
(function() {
  const headerRegisterBtn = document.querySelector('.register-btn');
  if (headerRegisterBtn) {
    headerRegisterBtn.addEventListener('click', () => {
      window.location.href = 'register.html';
    });
  }
})();

// Utility helpers
function pad2(n){ return String(n).padStart(2,'0'); }
function toDateParts(d){
  const yyyy = d.getFullYear();
  const mm = pad2(d.getMonth()+1);
  const dd = pad2(d.getDate());
  const HH = pad2(d.getHours());
  const MM = pad2(d.getMinutes());
  const SS = pad2(d.getSeconds());
  return { yyyy, mm, dd, HH, MM, SS, dateCompact: `${yyyy}${mm}${dd}`, timeCompact: `${HH}${MM}${SS}` };
}

// Step 1: Create Account
(function(){
  const form = document.getElementById('register-form');
  if (!form) return;

  // Prefill if exists
  try {
    const saved = JSON.parse(localStorage.getItem('registrationData') || 'null');
    if (saved) {
      const fi = form.querySelector('#first-initial');
      const li = form.querySelector('#last-initial');
      const p1 = form.querySelector('#phone1');
      const p2 = form.querySelector('#phone2');
      const dist = form.querySelector('#district');
      if (fi && saved.firstInitial) fi.value = saved.firstInitial;
      if (li && saved.lastInitial) li.value = saved.lastInitial;
      if (p1 && saved.phone1) p1.value = saved.phone1;
      if (p2 && saved.phone2) p2.value = saved.phone2;
      if (dist && saved.district) dist.value = saved.district;
    }
  } catch(_e){}

  form.addEventListener('submit', (e) => {
    e.preventDefault();
    const firstInitial = (form.querySelector('#first-initial').value || '').trim().toUpperCase();
    const lastInitial = (form.querySelector('#last-initial').value || '').trim().toUpperCase();
    const phone1 = (form.querySelector('#phone1').value || '').trim();
    const phone2 = (form.querySelector('#phone2').value || '').trim();
    const district = (form.querySelector('#district').value || '').trim();

    const errors = [];
    if (!/^[A-Z]$/.test(firstInitial)) errors.push('First name initial must be a single letter');
    if (!/^[A-Z]$/.test(lastInitial)) errors.push('Last name initial must be a single letter');
    if (!phone1) errors.push('Primary phone number is required');
    // secondary phone optional
    if (!district) errors.push('Please select your district');
    if (errors.length) { alert(errors.join('\n')); return; }

    const now = new Date();
    const p = toDateParts(now);
    const accountName = `${firstInitial}${lastInitial}${district.replace(/\s+/g,'')}${p.dateCompact}${p.timeCompact}`;

    const registrationData = {
      firstInitial, lastInitial, phone1, phone2, district,
      capturedAtISO: now.toISOString(),
      displayDate: now.toLocaleDateString('en-GB'),
      displayTime: now.toLocaleTimeString('en-GB'),
      dateCompact: p.dateCompact,
      timeCompact: p.timeCompact,
      accountName
    };
    localStorage.setItem('registrationData', JSON.stringify(registrationData));
    // window.location.href = 'register-review.html';
  });
})();

// Step 2: Review
(function(){
  const mount = document.getElementById('review-mount');
  if (!mount) return;
  const raw = localStorage.getItem('registrationData');
  if (!raw) { window.location.href = 'register.html'; return; }
  const data = JSON.parse(raw);
  const rows = document.getElementById('review-rows');
  if (rows) rows.innerHTML = `
    <div class="label">First Initial</div><div class="value">${data.firstInitial}</div>
    <div class="label">Last Initial</div><div class="value">${data.lastInitial}</div>
    <div class="label">Primary Phone</div><div class="value">${data.phone1}</div>
    <div class="label">Secondary Phone</div><div class="value">${data.phone2 || '-'}</div>
    <div class="label">District</div><div class="value">${data.district}</div>
    <div class="label">Date</div><div class="value">${data.displayDate}</div>
    <div class="label">Time</div><div class="value">${data.displayTime}</div>
    <div class="label">Profile ID</div><div class="value account-code">${data.accountName}</div>
  `;
  const back = document.getElementById('review-back');
  const next = document.getElementById('review-next');
  if (back) back.addEventListener('click', () => window.location.href = 'register.html');
  if (next) next.addEventListener('click', () => window.location.href = 'register-terms.html');
})();

// Step 3: Terms
(function(){
  const mount = document.getElementById('terms-mount');
  if (!mount) return;
  const proceed = document.getElementById('terms-proceed');
  if (proceed) {
    proceed.addEventListener('click', () => {
      const agree = document.getElementById('agree');
      const disagree = document.getElementById('disagree');
      if (agree && agree.checked) {
        window.location.href = 'profile.html';
      } else if (disagree && disagree.checked) {
        window.location.href = 'index.html';
      } else {
        alert('Please select I agree or I don\'t agree');
      }
    });
  }
})();

// Profile page
(function(){
  const mount = document.getElementById('profile-mount');
  if (!mount) return;
  const raw = localStorage.getItem('registrationData');
  if (!raw) { window.location.href = 'register.html'; return; }
  const data = JSON.parse(raw);
  const code = document.getElementById('account-code');
  const list = document.getElementById('profile-info-list');
  if (code) code.textContent = data.accountName;
  if (list) list.innerHTML = `
    <li><strong>First Initial:</strong> ${data.firstInitial}</li>
    <li><strong>Last Initial:</strong> ${data.lastInitial}</li>
    <li><strong>Primary Phone:</strong> ${data.phone1}</li>
    <li><strong>Secondary Phone:</strong> ${data.phone2}</li>
    <li><strong>District:</strong> ${data.district}</li>
    <li><strong>Date:</strong> ${data.displayDate}</li>
    <li><strong>Time:</strong> ${data.displayTime}</li>
  `;
  const goDash = document.getElementById('go-dashboard');
  if (goDash) goDash.addEventListener('click', () => window.location.href = 'dashboard.html');
})();

// Dashboard page
(function(){
  const mount = document.getElementById('dashboard-mount');
  if (!mount) return;
  const reg = JSON.parse(localStorage.getItem('registrationData') || 'null');
  const data = JSON.parse(localStorage.getItem('dashboardData') || '{"appointments":[],"counsel":[],"tests":[],"meds":[]}');
  const welcome = document.getElementById('welcome-title');
  if (welcome) {
    const nameText = reg ? `${reg.firstInitial || ''} ${reg.lastInitial || ''}`.trim() : '';
    welcome.textContent = nameText ? `Welcome, ${nameText}` : 'Welcome';
  }

  // Stats
  const statTests = document.getElementById('stat-tests');
  const statAppts = document.getElementById('stat-appointments');
  const statCouns = document.getElementById('stat-counsel');
  const statMeds = document.getElementById('stat-meds');
  if (statTests) statTests.textContent = String((data.tests||[]).length);
  if (statAppts) statAppts.textContent = String((data.appointments||[]).length);
  if (statCouns) statCouns.textContent = String((data.counsel||[]).length);
  if (statMeds) statMeds.textContent = String((data.meds||[]).length);

  // Bar chart
  const chart = document.getElementById('bar-chart');
  if (chart) {
    const series = [
      { label: 'Tests', value: (data.tests||[]).length },
      { label: 'Appts', value: (data.appointments||[]).length },
      { label: 'Counsel', value: (data.counsel||[]).length },
      { label: 'Meds', value: (data.meds||[]).length }
    ];
    const max = Math.max(1, ...series.map(s => s.value));
    chart.innerHTML = series.map(s => {
      const h = Math.round((s.value / max) * 100);
      return `<div class="bar"><div class="bar-fill" style="height:${h}%;"></div><div class="bar-label">${s.label}</div></div>`;
    }).join('');
  }

  // Calendar
  const cal = document.getElementById('calendar');
  const details = document.getElementById('calendar-details');
  const calTitle = document.getElementById('cal-title');
  const prevBtn = document.getElementById('cal-prev');
  const nextBtn = document.getElementById('cal-next');
  if (cal && calTitle && prevBtn && nextBtn) {
    let view = new Date();
    view.setDate(1);
    function buildEventsByDay(year, month){
      const byDay = {};
      function add(dateStr, info){
        const d = new Date(dateStr);
        if (d.getFullYear()!==year || d.getMonth()!==month) return;
        const day = d.getDate();
        (byDay[day] = byDay[day] || []).push(info);
      }
      (data.appointments||[]).forEach(e => add(e.date, { type: 'Appointment', ...e }));
      (data.counsel||[]).forEach(e => add(e.date, { type: 'Counselling', ...e }));
      (data.tests||[]).forEach(e => add(e.date, { type: 'Test Kit', ...e }));
      (data.meds||[]).forEach(e => add(e.date, { type: 'Medication', ...e }));
      return byDay;
    }
    function render(){
      const year = view.getFullYear();
      const month = view.getMonth();
      calTitle.textContent = `${view.toLocaleString('default', { month: 'long' })} ${year}`;
      const first = new Date(year, month, 1);
      const firstDow = first.getDay();
      const daysInMonth = new Date(year, month+1, 0).getDate();
      const eventsByDay = buildEventsByDay(year, month);
      const slots = [];
      for (let i=0;i<firstDow;i++) slots.push('<div class="day empty"></div>');
      for (let d=1; d<=daysInMonth; d++) {
        const has = !!eventsByDay[d];
        slots.push(`<div class="day${has?' highlight':''}" data-day="${d}">${d}</div>`);
      }
      cal.innerHTML = slots.join('');
      cal.onclick = (e) => {
        const dayEl = e.target.closest('.day');
        if (!dayEl || !dayEl.dataset.day) return;
        const d = Number(dayEl.dataset.day);
        const items = eventsByDay[d] || [];
        if (!items.length) { details.textContent = 'No items for this date.'; return; }
        details.innerHTML = items.map(it => {
          const when = [it.date, it.time].filter(Boolean).join(' ');
          const who = it.doctor || it.counselor || '';
          const where = it.place || it.ngo || '';
          const contact = it.meet || it.phone || '';
          return `
            <div class="detail-card">
              <div class="detail-title">${it.type}</div>
              <div class="detail-meta">${when}${who?` • ${who}`:''}${where?` • ${where}`:''}${contact?` • ${contact}`:''}</div>
            </div>`;
        }).join('');
      };
    }
    prevBtn.onclick = () => { view.setMonth(view.getMonth()-1); render(); };
    nextBtn.onclick = () => { view.setMonth(view.getMonth()+1); render(); };
    render();
  }

  // Boards rendering
  (function(){
    const tabs = document.getElementById('board-tabs');
    if (!tabs) return;
    function setActive(board){
      document.querySelectorAll('.board-tab').forEach(b => b.classList.toggle('active', b.dataset.board===board));
      document.querySelectorAll('.board-panel').forEach(p => p.classList.toggle('active', p.id===`board-${board}`));
    }
    tabs.addEventListener('click', (e)=>{
      const btn = e.target.closest('.board-tab');
      if (!btn) return;
      setActive(btn.dataset.board);
    });
    function td(v){ return `<td>${v??''}</td>`; }
    function timeParts(dateStr, timeStr){
      const d = dateStr || '';
      const t = timeStr || '';
      return { date: d, time: t };
    }
    const testsBody = document.getElementById('table-tests');
    if (testsBody) testsBody.innerHTML = (data.tests||[]).map(t => {
      const parts = timeParts(t.date, t.time);
      return `<tr>${td(t.track||t.tracking||'-')}${td(t.kitType||t.type||'-')}${td(parts.date)}${td(parts.time)}</tr>`;
    }).join('');
    const apptBody = document.getElementById('table-appointments');
    if (apptBody) apptBody.innerHTML = (data.appointments||[]).map(a => {
      return `<tr>${td(a.date)}${td(a.time)}${td(a.doctor||'-')}${td(a.meet||a.phone||'-')}</tr>`;
    }).join('');
    const counselBody = document.getElementById('table-counsel');
    if (counselBody) counselBody.innerHTML = (data.counsel||[]).map(c => {
      return `<tr>${td(c.date)}${td(c.time)}${td(c.counselor||'-')}${td(c.meet||c.phone||'-')}</tr>`;
    }).join('');
    const medsBody = document.getElementById('table-meds');
    if (medsBody) medsBody.innerHTML = (data.meds||[]).map(m => {
      const parts = timeParts(m.date, m.time);
      return `<tr>${td(m.orderId||'-')}${td(m.item||'Medication')}${td(parts.date)}${td(parts.time)}</tr>`;
    }).join('');
  })();
})();
