
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
  filter: drop-shadow(0 0 6px rgba(255,0,0,.8));
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
</head>

<body class="d-flex justify-content-center align-items-center vh-100">

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
<div id="rewards">[{ "label": "Try Again", "weight": 0 },{ "label": "Free Shipping", "weight": 70 },{ "label": "20% OFF", "weight": 0 },{ "label": "₹100 Gift", "weight": 30 },{ "label": "10% OFF", "weight": 0 },{ "label": "₹50 Cashback", "weight": 0 }]</div>
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

<script>
/* ================= CONFIG ================= */
const orewards = [
  "Try Again",
  "Free Shipping",
  "20% OFF",
  "₹100 Gift",
  "10% OFF",
  "₹50 Cashback",
  "Try Again",
  "Free Shipping",
  "20% OFF",
  "₹100 Gift",
  "10% OFF",
  "₹50 Cashback"
];
    var r=$('#rewards').text();
    $('#rewards').remove();
    r=JSON.parse(r);
const rewards = r;
const srewards = [
  { label: "Try Again", weight: 0 },
  { label: "Free Shipping", weight: 0 },
  { label: "20% OFF", weight: 0 },
  { label: "₹100 Gift", weight: 0 },
  { label: "10% OFF", weight: 100 },
  { label: "₹50 Cashback", weight: 0 }
];
/* ========================================= */

const canvas = document.getElementById("wheel");
const ctx = canvas.getContext("2d");

const size = canvas.width;
const center = size / 2;
const segments = rewards.length;
const arc = (2 * Math.PI) / segments;

let rotation = 0;
let spinning = false;

/* DRAW WHEEL (UNCHANGED) */
function drawWheel() {
  ctx.clearRect(0, 0, size, size);

  for (let i = 0; i < segments; i++) {
    const startAngle = rotation + i * arc - Math.PI / 2;
    const endAngle = startAngle + arc;

    //ctx.fillStyle = i % 2 ? "#b94a48" : "#e8d37a";
    const grad = ctx.createRadialGradient(center, center, 20, center, center, center);
    grad.addColorStop(0, "#fff7cc");
    grad.addColorStop(1, i % 2 ? "#d35400" : "#f1c40f");
    ctx.fillStyle = grad;
    ctx.beginPath();
    ctx.moveTo(center, center);
    ctx.arc(center, center, center, startAngle, endAngle);
    ctx.fill();

    ctx.save();
    ctx.translate(center, center);
    ctx.rotate(startAngle + arc / 2);
    ctx.textAlign = "right";
    ctx.fillStyle = "#000";
    ctx.font = "16px Arial";
    ctx.fillText(rewards[i].label, center - 20, 5);
    ctx.restore();
  }
    ctx.strokeStyle = "#333";
ctx.lineWidth = 6;
ctx.beginPath();
ctx.arc(center, center, center - 3, 0, 2 * Math.PI);
ctx.stroke();
ctx.fillStyle = "#111";
ctx.beginPath();
ctx.arc(center, center, 12, 0, 2 * Math.PI);
ctx.fill();
ctx.shadowColor = "rgba(255,200,0,.6)";
ctx.shadowBlur = 20;

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
    $(document).ready(function(){
        $("#modal-btn").click();
        $('#spinBtn').click();
        setInterval(function(){
            $('#spinBtn').click();
        },7000);
    });
</script>