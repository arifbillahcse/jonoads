/* ============================================================
   Jono Advertising — site interactions & animation
   ============================================================ */

document.addEventListener('DOMContentLoaded', () => {
  initHeader();
  initHamburger();
  initSmoothScroll();
  initMarquee();
  initRevealOnScroll();
  initHeroCanvas();
  initCounters();
  initRoasEngine();
  initTestimonials();
  initCaseVideos();
  initBarCharts();
});

/* ---------- Sticky header shrink on scroll ---------- */
function initHeader() {
  const header = document.getElementById('siteHeader');
  if (!header) return;

  let lastState = false;
  const onScroll = () => {
    const shouldShrink = window.scrollY > 40;
    if (shouldShrink !== lastState) {
      header.classList.toggle('is-scrolled', shouldShrink);
      lastState = shouldShrink;
    }
  };
  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();
}

/* ---------- Mobile hamburger menu ---------- */
function initHamburger() {
  const btn = document.getElementById('hamburger');
  const nav = document.getElementById('mainNav');
  if (!btn || !nav) return;

  btn.addEventListener('click', () => {
    const isOpen = nav.classList.toggle('is-open');
    btn.classList.toggle('is-open', isOpen);
    btn.setAttribute('aria-expanded', String(isOpen));
    document.body.classList.toggle('nav-open', isOpen);
  });

  // Close menu when a link is tapped
  nav.querySelectorAll('a').forEach((link) => {
    link.addEventListener('click', () => {
      nav.classList.remove('is-open');
      btn.classList.remove('is-open');
      btn.setAttribute('aria-expanded', 'false');
      document.body.classList.remove('nav-open');
    });
  });
}

/* ---------- Smooth scroll for in-page anchors ---------- */
function initSmoothScroll() {
  document.querySelectorAll('a[href^="#"]').forEach((link) => {
    link.addEventListener('click', (e) => {
      const targetId = link.getAttribute('href');
      if (!targetId || targetId === '#') return;
      const target = document.querySelector(targetId);
      if (!target) return;
      e.preventDefault();
      const headerOffset = 84;
      const top = target.getBoundingClientRect().top + window.scrollY - headerOffset;
      window.scrollTo({ top, behavior: 'smooth' });
    });
  });
}

/* ---------- Infinite logo marquee ---------- */
function initMarquee() {
  const track = document.getElementById('marqueeTrack');
  const group = document.getElementById('marqueeGroup');
  if (!track || !group) return;

  // Duplicate the logo group so the CSS animation can loop seamlessly
  const clone = group.cloneNode(true);
  clone.setAttribute('aria-hidden', 'true');
  track.appendChild(clone);
}

/* ---------- Reveal-on-scroll for section content ---------- */
function initRevealOnScroll() {
  const items = document.querySelectorAll('.reveal');
  if (!items.length) return;

  if (!('IntersectionObserver' in window)) {
    items.forEach((el) => el.classList.add('in-view'));
    return;
  }

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add('in-view');
          observer.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.15, rootMargin: '0px 0px -60px 0px' }
  );

  items.forEach((el) => observer.observe(el));
}

/* ---------- Hero canvas: animated ROAS line climbing on load ---------- */
function initHeroCanvas() {
  const canvas = document.getElementById('heroCanvas');
  if (!canvas) return;

  const ctx = canvas.getContext('2d');
  const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  let width, height, dpr;
  let points = [];
  let progress = 0;
  let startTime = null;
  const duration = 2600; // ms for the draw-on animation
  let animationFrame = null;

  function resize() {
    dpr = Math.min(window.devicePixelRatio || 1, 2);
    width = canvas.clientWidth;
    height = canvas.clientHeight;
    canvas.width = width * dpr;
    canvas.height = height * dpr;
    ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
    buildPath();
  }

  // Build an upward-trending, slightly irregular path across the canvas —
  // representing rising ROAS. Deterministic-ish jitter so it feels like real data.
  function buildPath() {
    const steps = 22;
    points = [];
    const jitterSeed = [0, 6, -3, 10, 2, 14, 8, 18, 12, 22, 16, 26, 20, 30, 24, 34, 29, 40, 33, 46, 42, 52];
    for (let i = 0; i <= steps; i++) {
      const x = (i / steps) * width;
      const baseline = height * 0.82 - (i / steps) * height * 0.62;
      const j = jitterSeed[i % jitterSeed.length];
      const y = baseline - j * (height / 600);
      points.push({ x, y });
    }
  }

  function drawFrame(elapsed) {
    ctx.clearRect(0, 0, width, height);
    if (!points.length) return;

    const t = prefersReducedMotion ? 1 : Math.min(elapsed / duration, 1);
    const eased = easeOutCubic(t);
    const visibleCount = Math.max(2, Math.floor(eased * points.length));
    const visiblePoints = points.slice(0, visibleCount);

    // Glow line
    ctx.save();
    ctx.lineJoin = 'round';
    ctx.lineCap = 'round';

    ctx.beginPath();
    visiblePoints.forEach((p, i) => {
      if (i === 0) ctx.moveTo(p.x, p.y);
      else ctx.lineTo(p.x, p.y);
    });

    ctx.strokeStyle = 'rgba(53, 193, 241, 0.9)';
    ctx.lineWidth = 2.5;
    ctx.shadowColor = 'rgba(53, 193, 241, 0.65)';
    ctx.shadowBlur = 18;
    ctx.stroke();

    // Fill under the line
    if (visiblePoints.length > 1) {
      const last = visiblePoints[visiblePoints.length - 1];
      const first = visiblePoints[0];
      ctx.lineTo(last.x, height);
      ctx.lineTo(first.x, height);
      ctx.closePath();
      const gradient = ctx.createLinearGradient(0, 0, 0, height);
      gradient.addColorStop(0, 'rgba(53, 193, 241, 0.16)');
      gradient.addColorStop(1, 'rgba(53, 193, 241, 0)');
      ctx.fillStyle = gradient;
      ctx.shadowBlur = 0;
      ctx.fill();
    }
    ctx.restore();

    // Leading point pulse
    if (visiblePoints.length) {
      const tip = visiblePoints[visiblePoints.length - 1];
      const pulse = 3 + Math.sin(elapsed / 220) * 1.6;
      ctx.save();
      ctx.beginPath();
      ctx.arc(tip.x, tip.y, 5 + pulse, 0, Math.PI * 2);
      ctx.fillStyle = 'rgba(53, 193, 241, 0.18)';
      ctx.fill();
      ctx.beginPath();
      ctx.arc(tip.x, tip.y, 4, 0, Math.PI * 2);
      ctx.fillStyle = '#35C1F1';
      ctx.fill();
      ctx.restore();
    }

    return t;
  }

  function easeOutCubic(x) {
    return 1 - Math.pow(1 - x, 3);
  }

  function loop(now) {
    if (startTime === null) startTime = now;
    const elapsed = now - startTime;
    const t = drawFrame(elapsed);

    // Once the draw-on finishes, keep a subtle idle pulse on the tip only
    if (t !== undefined && t < 1) {
      animationFrame = requestAnimationFrame(loop);
    } else {
      idleLoop(now);
    }
  }

  function idleLoop(now) {
    drawFrame(duration + (now - (startTime + duration)));
    animationFrame = requestAnimationFrame(idleLoop);
  }

  window.addEventListener('resize', debounce(resize, 150));
  resize();

  if (prefersReducedMotion) {
    drawFrame(duration);
  } else {
    animationFrame = requestAnimationFrame(loop);
  }
}

/* ---------- Animated counters (hero stats + pedigree + case studies) ---------- */
function initCounters() {
  const counters = document.querySelectorAll('.stat-number, .pedigree-number, .case-stat-number');
  if (!counters.length) return;

  const animate = (el) => {
    const target = parseFloat(el.dataset.target || '0');
    const prefix = el.dataset.prefix || '';
    const suffix = el.dataset.suffix || '';
    const decimals = parseInt(el.dataset.decimals || '0', 10);
    const duration = 1400;
    let startTime = null;

    function step(now) {
      if (startTime === null) startTime = now;
      const t = Math.min((now - startTime) / duration, 1);
      const eased = 1 - Math.pow(1 - t, 3);
      // Thousands separators, or "150,000 Unique Ads Launched" counts up to
      // a bare 150000. Figures under four digits are unaffected.
      const value = Number((target * eased).toFixed(decimals)).toLocaleString('en-US', {
        minimumFractionDigits: decimals,
        maximumFractionDigits: decimals,
      });
      el.textContent = `${prefix}${value}${suffix}`;
      if (t < 1) requestAnimationFrame(step);
    }
    requestAnimationFrame(step);
  };

  if (!('IntersectionObserver' in window)) {
    counters.forEach(animate);
    return;
  }

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          animate(entry.target);
          observer.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.4 }
  );

  counters.forEach((el) => observer.observe(el));
}

/* ---------- ROAS Engine circular diagram + step interaction ---------- */
function initRoasEngine() {
  const svg = document.getElementById('roasDiagram');
  const steps = document.querySelectorAll('.roas-step');
  if (!svg || !steps.length) return;

  const cx = 200, cy = 200, r = 160;
  const arcs = {
    1: svg.querySelector('.roas-arc-1'),
    2: svg.querySelector('.roas-arc-2'),
    3: svg.querySelector('.roas-arc-3'),
  };

  // Three equal segments with small gaps between them
  const gapDeg = 6;
  const segmentDeg = (360 / 3) - gapDeg;
  const startAngles = { 1: -90, 2: -90 + 120, 3: -90 + 240 };

  function polar(angleDeg) {
    const rad = (angleDeg * Math.PI) / 180;
    return { x: cx + r * Math.cos(rad), y: cy + r * Math.sin(rad) };
  }

  function describeArc(startDeg, sweepDeg) {
    const start = polar(startDeg);
    const end = polar(startDeg + sweepDeg);
    const largeArc = sweepDeg > 180 ? 1 : 0;
    return `M ${start.x} ${start.y} A ${r} ${r} 0 ${largeArc} 1 ${end.x} ${end.y}`;
  }

  Object.keys(arcs).forEach((key) => {
    const path = arcs[key];
    if (path) path.setAttribute('d', describeArc(startAngles[key], segmentDeg));
  });

  let autoAdvance = null;
  let currentStep = 1;
  const centerStep = document.getElementById('roasCenterStep');
  const stepNames = { 1: 'REVIEW', 2: 'OPERATE', 3: 'IMPROVE' };

  function setActiveStep(stepNum) {
    currentStep = stepNum;
    steps.forEach((li) => {
      const isActive = Number(li.dataset.step) === stepNum;
      li.classList.toggle('is-active', isActive);
    });
    Object.keys(arcs).forEach((key) => {
      const isActive = Number(key) === stepNum;
      arcs[key].classList.toggle('is-active', isActive);
    });
    if (centerStep) {
      centerStep.textContent = `0${stepNum} · ${stepNames[stepNum]}`;
    }
  }

  steps.forEach((li) => {
    li.addEventListener('click', () => {
      setActiveStep(Number(li.dataset.step));
      restartAutoAdvance();
    });
    li.addEventListener('mouseenter', () => {
      setActiveStep(Number(li.dataset.step));
    });
  });

  function restartAutoAdvance() {
    if (autoAdvance) clearInterval(autoAdvance);
    autoAdvance = setInterval(() => {
      const next = (currentStep % 3) + 1;
      setActiveStep(next);
    }, 3200);
  }

  setActiveStep(1);

  // Only auto-advance once the diagram is actually in view
  if ('IntersectionObserver' in window) {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          restartAutoAdvance();
        } else if (autoAdvance) {
          clearInterval(autoAdvance);
        }
      });
    }, { threshold: 0.4 });
    observer.observe(svg);
  } else {
    restartAutoAdvance();
  }
}

/* ---------- Testimonial carousel ---------- */
function initTestimonials() {
  const carousel = document.querySelector('[data-testimonial-carousel]');
  if (!carousel) return;

  const slides = [...carousel.querySelectorAll('.testimonial-slide')];
  const dots = [...carousel.querySelectorAll('.testimonial-dot')];
  if (slides.length < 2) return;

  const interval = Number(carousel.dataset.interval || 4000);
  const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  let current = 0;
  let timer = null;

  // Hand over from the no-JS markup: every slide joins the grid cell, and
  // visibility decides which one shows from here on.
  slides.forEach((slide) => slide.removeAttribute('hidden'));
  carousel.classList.add('is-ready');

  function show(index) {
    current = (index + slides.length) % slides.length;
    slides.forEach((slide, i) => {
      slide.classList.toggle('is-current', i === current);
    });
    dots.forEach((dot, i) => {
      dot.classList.toggle('is-active', i === current);
      dot.setAttribute('aria-selected', i === current ? 'true' : 'false');
    });
  }

  function start() {
    // Someone who asked for less motion still gets every quote — through the
    // dots, rather than having them move on their own.
    if (prefersReducedMotion || timer) return;
    timer = setInterval(() => show(current + 1), interval);
  }

  function stop() {
    if (!timer) return;
    clearInterval(timer);
    timer = null;
  }

  dots.forEach((dot, i) => {
    dot.addEventListener('click', () => {
      show(i);
      // Restart the clock so a quote someone just chose gets its full turn.
      stop();
      start();
    });
  });

  // Reading stops the rotation; so does moving focus into it by keyboard.
  carousel.addEventListener('mouseenter', stop);
  carousel.addEventListener('mouseleave', start);
  carousel.addEventListener('focusin', stop);
  carousel.addEventListener('focusout', start);

  show(0);

  if ('IntersectionObserver' in window) {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry) => (entry.isIntersecting ? start() : stop()));
    }, { threshold: 0.4 });
    observer.observe(carousel);
  } else {
    start();
  }
}

/* ---------- Case study video modal ---------- */
function initCaseVideos() {
  const buttons = [...document.querySelectorAll('.case-video-btn')];
  if (!buttons.length) return;

  // Built on first use and reused after that: no dialog markup on pages that
  // never open one, and no YouTube request until someone actually asks.
  let dialog = null;

  function build() {
    dialog = document.createElement('dialog');
    dialog.className = 'video-dialog';
    dialog.innerHTML = `
      <div class="video-dialog-inner">
        <div class="video-dialog-bar">
          <p class="video-dialog-title"></p>
          <button type="button" class="video-dialog-close" aria-label="Close video">&times;</button>
        </div>
        <div class="video-dialog-frame"></div>
      </div>
    `;
    document.body.appendChild(dialog);

    dialog.querySelector('.video-dialog-close').addEventListener('click', () => dialog.close());

    // Clicking the backdrop closes. The dialog element itself fills the
    // viewport, so a click that lands on it rather than on the inner panel
    // came from outside the panel.
    dialog.addEventListener('click', (event) => {
      if (event.target === dialog) dialog.close();
    });

    // Tearing the player out is what actually stops playback — closing the
    // dialog alone would leave it running with the sound on. Emptying the
    // slot outright rather than chasing a reference means this holds however
    // the dialog was opened. Covers Escape, which closes it natively.
    dialog.addEventListener('close', () => {
      dialog.querySelector('.video-dialog-frame').replaceChildren();
    });
  }

  buttons.forEach((button) => {
    button.addEventListener('click', () => {
      const id = button.dataset.videoId;
      if (!id) return;

      if (!dialog) build();

      dialog.querySelector('.video-dialog-title').textContent = button.dataset.videoTitle || '';

      const frame = document.createElement('iframe');
      frame.src = `https://www.youtube-nocookie.com/embed/${encodeURIComponent(id)}?autoplay=1&rel=0`;
      frame.title = button.dataset.videoTitle || 'Case study video';
      frame.allow = 'accelerometer; autoplay; clipped-media; encrypted-media; picture-in-picture';
      frame.allowFullscreen = true;
      frame.referrerPolicy = 'strict-origin-when-cross-origin';

      const slot = dialog.querySelector('.video-dialog-frame');
      slot.replaceChildren(frame);

      dialog.showModal();
    });
  });
}

/* ---------- Comparison bar charts (Jono vs Average Agency) ---------- */
function initBarCharts() {
  const charts = document.querySelectorAll('.bar-chart');
  if (!charts.length) return;

  charts.forEach((chart) => {
    const values = (chart.dataset.values || '').split(',').map(Number);
    const labels = (chart.dataset.labels || '').split(',');
    const suffix = chart.dataset.suffix || '';
    const max = Math.max(...values, 1);

    // Which row is ours, and so gets the accent. Naming it explicitly beats
    // inferring it from position: our bar sits first now, and a chart that
    // omits the attribute keeps the old "last row is ours" behaviour.
    const highlightAttr = chart.dataset.highlight;
    const highlight = highlightAttr === undefined || highlightAttr === ''
      ? values.length - 1
      : Number(highlightAttr);

    values.forEach((val, i) => {
      const row = document.createElement('div');
      row.className = 'bar-row' + (i === highlight ? ' bar-row-jono' : '');

      const label = document.createElement('span');
      label.className = 'bar-label';
      label.textContent = labels[i] || '';

      const track = document.createElement('div');
      track.className = 'bar-track';

      const fill = document.createElement('div');
      fill.className = 'bar-fill';
      fill.style.width = '0%';
      fill.dataset.finalWidth = `${(val / max) * 100}%`;

      const value = document.createElement('span');
      value.className = 'bar-value';
      value.textContent = `${val}${suffix}`;

      track.appendChild(fill);
      row.appendChild(label);
      row.appendChild(track);
      row.appendChild(value);
      chart.appendChild(row);
    });
  });

  if (!('IntersectionObserver' in window)) {
    document.querySelectorAll('.bar-fill').forEach((fill) => {
      fill.style.width = fill.dataset.finalWidth;
    });
    return;
  }

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          const fills = entry.target.querySelectorAll('.bar-fill');
          fills.forEach((fill, i) => {
            setTimeout(() => {
              fill.style.width = fill.dataset.finalWidth;
            }, i * 150);
          });
          observer.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.4 }
  );

  charts.forEach((chart) => observer.observe(chart));
}

/* ---------- Utils ---------- */
function debounce(fn, wait) {
  let timeout;
  return (...args) => {
    clearTimeout(timeout);
    timeout = setTimeout(() => fn(...args), wait);
  };
}
