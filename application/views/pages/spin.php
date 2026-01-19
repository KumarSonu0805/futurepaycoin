<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Spin & Win</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
body {
  font-family: Arial, sans-serif;
  background:#eee;
  text-align:center;
  padding-top:40px;
}

button {
  padding:12px 28px;
  font-size:16px;
  cursor:pointer;
}

.spin-modal {
  display:none;
  position:fixed;
  inset:0;
  background:rgba(0,0,0,.55);
  justify-content:center;
  align-items:center;
  z-index:9999;
}

.modal-box {
  background:#fff;
  padding:20px;
  border-radius:12px;
  position:relative;
  width:460px;
}

.close {
  position:absolute;
  top:12px;
  right:16px;
  font-size:26px;
  cursor:pointer;
}

.pointer {
  width: 0;
  height: 0;
  border-left: 18px solid transparent;
  border-right: 18px solid transparent;
  border-top: 30px solid red; /* 🔥 DOWNWARD */
  position: absolute;
  top: -2px;
  left: 50%;
  transform: translateX(-50%);
}

canvas {
  display:block;
  margin:auto;
}
</style>
</head>

<body>

<h2>🎉 Spin & Win</h2>
<button id="openWheel">Spin & Win</button>

<div class="spin-modal" id="spinModal">
  <div class="modal-box">
    <div class="pointer"></div>
    <span class="close" id="closeWheel">×</span>

    <canvas id="wheel" width="400" height="400"></canvas>
    <br>
    <button id="spinBtn">SPIN</button>
  </div>
</div>

<script>
/* ================= CONFIG ================= */
const rewards = [
  "Try Again",
  "Free Shipping",
  "20% OFF",
  "₹100 Gift",
  "10% OFF",
  "₹50 Cashback"
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

/* DRAW WHEEL (ROTATED -90deg) */
function drawWheel() {
  ctx.clearRect(0, 0, size, size);

  for (let i = 0; i < segments; i++) {
    const startAngle = rotation + i * arc - Math.PI / 2;
    const endAngle = startAngle + arc;

    ctx.fillStyle = i % 2 ? "#b94a48" : "#e8d37a";
    ctx.beginPath();
    ctx.moveTo(center, center);
    ctx.arc(center, center, center, startAngle, endAngle);
    ctx.fill();

    // Text
    ctx.save();
    ctx.translate(center, center);
    ctx.rotate(startAngle + arc / 2);
    ctx.textAlign = "right";
    ctx.fillStyle = "#000";
    ctx.font = "16px Arial";
    ctx.fillText(rewards[i], center - 20, 5);
    ctx.restore();
  }
}

drawWheel();

/* SPIN LOGIC (POINTER-ACCURATE) */
document.getElementById("spinBtn").onclick = () => {
  if (spinning) return;
  spinning = true;

  const spinTurns = Math.random() * 4 + 5; // full spins
  const targetRotation = spinTurns * 2 * Math.PI + Math.random() * 2 * Math.PI;

  const start = performance.now();
  const duration = 4000;

  function animate(time) {
    const progress = Math.min((time - start) / duration, 1);
    rotation = targetRotation * easeOut(progress);
    drawWheel();

    if (progress < 1) {
      requestAnimationFrame(animate);
    } else {
      spinning = false;

      // 🔥 PERFECT POINTER ALIGNMENT
      const normalized =
        (2 * Math.PI - (rotation % (2 * Math.PI))) % (2 * Math.PI);

      const index = Math.floor(normalized / arc);

      console.log("🎉 You won: " + rewards[index]);
    }
  }

  requestAnimationFrame(animate);
};

function easeOut(t) {
  return 1 - Math.pow(1 - t, 3);
}

/* MODAL */
const modal = document.getElementById("spinModal");
document.getElementById("openWheel").onclick = () => modal.style.display = "flex";
document.getElementById("closeWheel").onclick = () => modal.style.display = "none";
</script>


</body>
</html>
