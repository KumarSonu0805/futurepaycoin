
<style>

/* Wheel wrapper for responsiveness */
.wheel-wrapper {
  position: relative;
  width: 100%;
  max-width: 360px;
  aspect-ratio: 1 / 1;
  margin: auto;
}

/* Canvas responsive scaling */
canvas {
  width: 100%;
  height: auto;
  display: block;
}

/* Pointer (UNCHANGED DIRECTION) */
.pointer {
  width: 0;
  height: 0;
  border-left: 18px solid transparent;
  border-right: 18px solid transparent;
  border-top: 30px solid red;
  position: absolute;
  top: -2px;
  left: 50%;
  transform: translateX(-50%);
  z-index: 5;
  filter: drop-shadow(0 0 8px rgba(255,0,0,.8));
}
#confetti-canvas {
  position: fixed;
  inset: 0;
  z-index: 2000; /* ABOVE Bootstrap modal */
  pointer-events: none;
}

@keyframes bounce {
  0%,100% { transform: translateX(-50%) scale(1); }
  50% { transform: translateX(-50%) scale(1.15); }
}
.spinning .pointer {
  animation: bounce .15s infinite;
}

    
/* Mobile adjustment */
@media (max-width: 576px) {
  .wheel-wrapper {
    max-width: 280px;
  }
}
</style>
<button class="btn btn-dark px-4"
        data-bs-toggle="modal"
        data-bs-target="#spinModal" id="modal-btn">
  🎉 Spin & Win
</button>
<div id="reward"></div>
<!-- Bootstrap Modal -->
<div class="modal fade" id="spinModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4">

      <div class="modal-header border-0">
        <h5 class="modal-title">🎉 Spin & Win</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body text-center">
<div class="mt-3 d-flex justify-content-center gap-2">
  <button class="btn btn-sm btn-outline-dark" onclick="setTheme('classicCasino')">Classic</button>
  <button class="btn btn-sm btn-outline-dark" onclick="setTheme('darkCasino')">Dark</button>
  <button class="btn btn-sm btn-outline-dark" onclick="setTheme('neonVegas')">Neon</button>
  <button class="btn btn-sm btn-outline-dark" onclick="setTheme('futurePayCoin')">Future Pay</button>
</div>

        <div class="wheel-wrapper">
          <div class="pointer"></div>
          <!-- INTERNAL SIZE UNCHANGED -->
          <canvas id="wheel" width="400" height="400"></canvas>
        </div>

        <button id="spinBtn" class="btn btn-outline-dark mt-4 px-5">
          SPIN
        </button>

      </div>
    </div>
  </div>
</div>
<canvas id="confetti-canvas"></canvas>
<div id="rewards"><?= json_encode($rewards); ?></div>
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

<script>
/* ================= CONFIG ================= */
var r=$('#rewards').text();
$('#rewards').remove();
r=JSON.parse(r);
const rewards = r;
/* ========================================= */

const canvas = document.getElementById("wheel");
const ctx = canvas.getContext("2d");

const size = canvas.width;
const center = size / 2;
const segments = rewards.length;
const arc = (2 * Math.PI) / segments;

let rotation = 0;
let spinning = false;

const themes = {
  classicCasino: {
    sliceA: "#8b0000",
    sliceB: "#f4d03f",
    text: "#111",
    border: "#2c2c2c",
    center: "#111",
    glow: "rgba(255,215,0,.6)",
    font: "bold 18px Georgia"
  },

  darkCasino: {
    sliceA: "#1f2933",
    sliceB: "#374151",
    text: "#f9fafb",
    border: "#111827",
    center: "#000",
    glow: "rgba(0,255,255,.4)",
    font: "bold 17px 'Segoe UI'"
  },

  neonVegas: {
    sliceA: "#ff005d",
    sliceB: "#00eaff",
    text: "#000",
    border: "#000",
    center: "#000",
    glow: "rgba(255,0,255,.8)",
    font: "bold 18px Arial"
  }, 
  futurePayCoin: {
    sliceA: "#D4AF37",   // rich gold
    sliceB: "#B8962E",   // bronze gold
    text: "#1A1408",     // dark contrast
    border: "#3A2C12",   // deep edge
    center: "#B8962E",   // center dot
    glow: "rgba(255,215,0,0.6)",
    font: "bold 18px 'Georgia', serif"
  }
};
const segmentColors = [
  "#D4AF37", // gold
  "#C0392B", // red
  "#27AE60", // green
  "#2980B9", // blue
  "#8E44AD", // purple
  "#F39C12", // orange
  "#16A085", // teal
  "#E84393"  // pink
];

let multiColor = false;

let currentTheme = themes.futurePayCoin;

    
/* DRAW WHEEL (UNCHANGED) */
function drawWheel() {
  ctx.clearRect(0, 0, size, size);

  /* ================= SLICES ================= */
  for (let i = 0; i < segments; i++) {
    const startAngle = rotation + i * arc - Math.PI / 2;
    const endAngle = startAngle + arc;

    // Gold slices
    if(multiColor){
        ctx.fillStyle = segmentColors[i % segmentColors.length];
    }
    else{
        ctx.fillStyle = i % 2 ? currentTheme.sliceA : currentTheme.sliceB;
    }
    ctx.beginPath();
    ctx.moveTo(center, center);
    ctx.arc(center, center, center - 8, startAngle, endAngle);
    ctx.fill();

    /* ========== ENGRAVED TEXT ========== */
    ctx.save();
    ctx.translate(center, center);
    ctx.rotate(startAngle + arc / 2);
    ctx.textAlign = "right";
    ctx.font = currentTheme.font;

    // Shadow (engrave depth)
    //ctx.fillStyle = "rgba(0,0,0,0.45)";
    //ctx.fillText(rewards[i].label, center - 38, 6);

    // Highlight (metal edge)
    //ctx.fillStyle = "rgba(255,255,255,0.35)";
    //ctx.fillText(rewards[i].label, center - 36, 4);

    // Main text
    ctx.fillStyle = currentTheme.text;
    ctx.fillText(rewards[i].label, center - 37, 5);

    ctx.restore();
    ctx.shadowColor = currentTheme.glow;
    ctx.shadowBlur = 15;
  }

  /* ================= METALLIC LIGHT SWEEP ================= */
  /*const sweepPos = (rotation % (2 * Math.PI)) / (2 * Math.PI);
  const sweep = ctx.createLinearGradient(0, 0, size, size);

  sweep.addColorStop(Math.max(0, sweepPos - 0.15), "rgba(255,255,255,0)");
  sweep.addColorStop(sweepPos, "rgba(255,255,255,0.35)");
  sweep.addColorStop(Math.min(1, sweepPos + 0.15), "rgba(255,255,255,0)");

  ctx.globalCompositeOperation = "lighter";
  ctx.fillStyle = sweep;
  ctx.beginPath();
  ctx.arc(center, center, center - 12, 0, 2 * Math.PI);
  ctx.fill();
  ctx.globalCompositeOperation = "source-over";*/

  /* ================= GOLD GLOW RIM ================= */
  ctx.save();
  ctx.shadowColor = currentTheme.glow;
  ctx.shadowBlur = 15;
  ctx.strokeStyle = currentTheme.sliceA;
  ctx.lineWidth = 6;
  ctx.beginPath();
  ctx.arc(center, center, center - 6, 0, 2 * Math.PI);
  ctx.stroke();

  ctx.restore();
    
    
  /* ================= ENGRAVED COIN RIM ================= */

  // Outer rim groove
  ctx.strokeStyle = currentTheme.sliceB;
  ctx.lineWidth = 6;
  ctx.beginPath();
  ctx.arc(center, center, center - 3, 0, 2 * Math.PI);
  ctx.stroke();

  // Inner rim groove
  ctx.strokeStyle = "#F5E08A";
  ctx.lineWidth = 2;
  ctx.beginPath();
  ctx.arc(center, center, center - 14, 0, 2 * Math.PI);
  ctx.stroke();

  // Coin dots (engraved rim beads)
  for (let i = 0; i < 48; i++) {
    const a = (i / 48) * 2 * Math.PI;
    ctx.fillStyle = "#F5E08A";
    ctx.beginPath();
    ctx.arc(
      center + Math.cos(a) * (center - 9),
      center + Math.sin(a) * (center - 9),
      2.6,
      0,
      2 * Math.PI
    );
    ctx.fill();
  }

  /* ================= CENTER COIN ================= */
  ctx.fillStyle = currentTheme.center;
  ctx.beginPath();
  ctx.arc(center, center, 12, 0, 2 * Math.PI);
  ctx.fill();
}

drawWheel();

const confettiCanvas = document.getElementById("confetti-canvas");
const myConfetti = confetti.create(confettiCanvas, {
  resize: true,
  useWorker: true
});

function weightedRandomIndex(items) {
  const total = items.reduce((s, i) => s + i.weight, 0);
  let r = Math.random() * total;

  for (let i = 0; i < items.length; i++) {
    r -= items[i].weight;
    if (r <= 0) return i;
  }
  return 0;
}

    
/* SPIN LOGIC (UNCHANGED) */
document.getElementById("spinBtn").onclick = () => {
  if (spinning) return;
  spinning = true;

  //const spinTurns = Math.random() * 4 + 5;
  //const targetRotation = spinTurns * 2 * Math.PI + Math.random() * 2 * Math.PI;
  const winIndex = weightedRandomIndex(rewards);
  const targetAngle = (segments - winIndex) * arc - arc / 2;
  const spinTurns = Math.floor(Math.random() * 4) + 5;
    
  const targetRotation = spinTurns * 2 * Math.PI + targetAngle;

  const start = performance.now();
  const duration = 4000;
  document.querySelector(".wheel-wrapper").classList.add("spinning");

  function animate(time) {
    const progress = Math.min((time - start) / duration, 1);
    rotation = targetRotation * easeOut(progress);
    drawWheel();

    if (progress < 1) {
      requestAnimationFrame(animate);
    } else {
      spinning = false;

      const normalized =
        (2 * Math.PI - (rotation % (2 * Math.PI))) % (2 * Math.PI);

      const index = Math.floor(normalized / arc);
      document.querySelector(".wheel-wrapper").classList.remove("spinning");
      const wonReward = rewards[index].label;
      console.log("🎉 You won:", wonReward);
        
      $('#reward').append('<p>'+wonReward+'</p>');
        myConfetti({
  particleCount: 150,
  spread: 70,
  origin: { y: 0.6 }
});

    }
  }

  requestAnimationFrame(animate);
};

function easeOut(t) {
  return 1 - Math.pow(1 - t, 3);
}
    function setTheme(name) {
  currentTheme = themes[name];
  drawWheel();
}

    $(document).ready(function(){
        $("#modal-btn").click();
        $('#spinBtn').click();
        setInterval(function(){
            //$('#spinBtn').click();
        },7000);
    });
</script>