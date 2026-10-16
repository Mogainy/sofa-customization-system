<?php
session_start();
include("config/db.php");

// --- safe product lookup ---
$id = intval($_GET['id'] ?? 0);
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();
if (!$row) { die("Product not found."); }

// --- load materials from DB so prices match phpMyAdmin ---
$matRes = mysqli_query($conn, "SELECT material_name, extra_cost FROM materials ORDER BY id");
$materials = [];
while ($m = mysqli_fetch_assoc($matRes)) { $materials[] = $m; }

$loggedIn = !empty($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Customize <?= htmlspecialchars($row['name']) ?> — Gikomba Sofa Workshop</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<style>
  *{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',Arial,sans-serif}
  body{background:#f4f6f9;color:#222;line-height:1.5}
  .header{background:#2b1f17;color:#fff;padding:18px 32px;display:flex;justify-content:space-between;align-items:center}
  .header h1{font-size:20px;letter-spacing:1px}
  .header nav a{color:#fff;text-decoration:none;margin-left:18px;font-size:14px}
  .header nav a:hover{color:#d97a45}
  .container{width:95%;max-width:1200px;margin:24px auto;display:grid;grid-template-columns:1.2fr 1fr;gap:28px;background:#fff;padding:28px;border-radius:16px;box-shadow:0 8px 24px rgba(0,0,0,.08)}
  @media(max-width:900px){.container{grid-template-columns:1fr}}
  .preview{display:flex;flex-direction:column;align-items:center;justify-content:center;background:linear-gradient(135deg,#fafafa,#ece4d6);border-radius:12px;padding:16px;min-height:480px}
  #sofaCanvas{max-width:100%;height:auto;border-radius:10px;cursor:pointer}
  .hint{margin-top:10px;color:#666;font-size:13px}
  .details h2{font-size:24px;margin-bottom:6px}
  .details .desc{color:#5a4a3a;font-size:14px;margin-bottom:10px}
  .price{font-size:30px;font-weight:700;color:#1cc88a;margin:10px 0 20px}
  .section{margin-top:18px}
  .section h3{margin-bottom:8px;font-size:14px;text-transform:uppercase;letter-spacing:1px;color:#5a4a3a}
  select,input,textarea{width:100%;padding:10px 12px;margin-bottom:8px;border:1px solid #d0d4dc;border-radius:8px;font-size:14px;background:#fff}
  textarea{resize:vertical;min-height:60px}
  .colors{display:flex;gap:10px;flex-wrap:wrap}
  .color-btn{width:42px;height:42px;border-radius:50%;border:3px solid #fff;box-shadow:0 0 0 2px #d0d4dc;cursor:pointer;padding:0;transition:transform .15s}
  .color-btn:hover{transform:scale(1.1)}
  .color-btn.active{box-shadow:0 0 0 3px #d97a45}
  .mats{display:flex;flex-wrap:wrap;gap:8px}
  .mat{padding:8px 14px;border:2px solid #d0d4dc;border-radius:8px;cursor:pointer;font-size:13px;background:#fff}
  .mat.active{border-color:#d97a45;background:#fff4ec;color:#d97a45;font-weight:600}
  .order-btn{width:100%;padding:14px;background:#d97a45;color:#fff;border:none;border-radius:10px;font-size:16px;font-weight:600;cursor:pointer;margin-top:18px}
  .order-btn:hover{background:#b8602f}
  .order-btn:disabled{background:#aaa;cursor:not-allowed}
  .badge{display:inline-block;background:#fff4ec;color:#d97a45;padding:4px 10px;border-radius:12px;font-size:12px;font-weight:600;margin-left:8px}
  .login-note{background:#fff3cd;color:#856404;padding:10px;border-radius:8px;font-size:14px;text-align:center}
  .login-note a{color:#856404;font-weight:700}
</style>
</head>
<body>

<div class="header">
  <h1>GIKOMBA SOFA WORKSHOP</h1>
  <nav>
    <a href="index.php">Sofas</a>
    <?php if ($loggedIn): ?>
      <a href="my_orders.php">My Orders</a>
      <a href="logout.php">Logout</a>
    <?php else: ?>
      <a href="login.php">Login</a>
      <a href="register.php">Register</a>
      
    <?php endif; ?>
  </nav>
</div>

<div class="sofa-preview">
    <canvas id="sofaCanvas"></canvas>
</div>

  <!-- RIGHT: details + form -->
  <div class="details">
    <h2><?= htmlspecialchars($row['name']) ?> <span class="badge" id="activePartBadge">
Sofa Body
</span>
    <p class="desc"><?= htmlspecialchars($row['description']) ?></p>
    <div class="price">Ksh <span id="totalPrice"><?= number_format($row['price']) ?></span></div>
    <input type="hidden" id="basePrice" value="<?= floatval($row['price']) ?>">

    <div class="section">
      <h3>Select Sofa Part</h3>
      <select id="partSelector">
    <option value="sofa_body">Sofa Body</option>
    <option value="pillows">Pillows</option>
</select>
    </div>

    <div class="section">
      <h3>Select Color</h3>
      <div class="colors" id="colorRow">
        <button type="button" class="color-btn" data-color="#b22222" style="background:#b22222" title="Crimson"></button>
        <button type="button" class="color-btn" data-color="#1e4fb8" style="background:#1e4fb8" title="Royal Blue"></button>
        <button type="button" class="color-btn" data-color="#1f7a4d" style="background:#1f7a4d" title="Emerald"></button>
        <button type="button" class="color-btn" data-color="#2d2d2d" style="background:#2d2d2d" title="Charcoal"></button>
        <button type="button" class="color-btn" data-color="#888888" style="background:#888888" title="Grey"></button>
        <button type="button" class="color-btn" data-color="#7B3F00" style="background:#7B3F00" title="Walnut"></button>
        <button type="button" class="color-btn" data-color="#c8b896" style="background:#c8b896" title="Beige"></button>
        <button type="button" class="color-btn" data-color="#6b2d5c" style="background:#6b2d5c" title="Plum"></button>
      </select>
    </div>

    <div class="section">
      <h3>Material</h3>
      <div class="mats" id="matRow">
        <?php foreach ($materials as $i => $m): ?>
          <div class="mat<?= $i===0?' active':'' ?>"
               data-name="<?= htmlspecialchars($m['material_name']) ?>"
               data-extra="<?= floatval($m['extra_cost']) ?>">
            <?= htmlspecialchars(ucfirst($m['material_name'])) ?>
            <?php if ((float)$m['extra_cost'] > 0): ?>
              <small style="color:#888"> +<?= number_format($m['extra_cost']) ?></small>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <form action="review_order.php" method="POST" id="orderForm">
      <input type="hidden" name="product_id" value="<?= (int)$row['id'] ?>">
     <input type="hidden" name="sofa_color" id="sofaColor">
<input type="hidden" name="sofa_texture" id="sofaTexture">

<input type="hidden" name="pillow_color" id="pillowColor">
<input type="hidden" name="pillow_texture" id="pillowTexture">
      <input type="hidden" name="total_price" id="finalPrice"  value="<?= floatval($row['price']) ?>">
<input type="hidden" name="custom_image" id="customImage">

      <div class="section">
        <h3>Phone Number</h3>
        <input type="text" name="phone" placeholder="07XX XXX XXX" required>
       
      </div>

      <div class="section">
        <h3>Delivery Address</h3>
        <textarea name="delivery_address" placeholder="Estate, street, house number…" required></textarea>
      </div>

      <div class="section">
        <h3>Payment Method</h3>
        <select name="payment_method">
          <option>M-Pesa</option>
          <option>Cash On Delivery</option>
          <option>Bank Transfer</option>
        </select>
      </div>

      <?php if ($loggedIn): ?>
        <button type="submit" class="order-btn">Place Order</button>
      <?php else: ?>
        <div class="login-note">Please <a href="login.php">login</a> or <a href="register.php">register</a> to place an order.</div>
        <button type="submit" class="order-btn" disabled>Place Order</button>
      <?php endif; ?>
    </form>
  </div>
</div>

<script>
// ============================================================
//  PROFESSIONAL SOFA CUSTOMIZER (Canvas + Mask Compositing)
//  - Grayscale base photo for realistic tinting
//  - Pre-loads ALL masks once -> no flicker, deterministic redraw
//  - "multiply" blend = real fabric look (keeps shadows/highlights)
//  - Per-part state + "Whole Sofa" + click-on-canvas to pick a part
// ============================================================

// ===============================
// SIMPLE SOFA CUSTOMIZER
// ===============================

const textures = {
    linen: new Image(),
    velvet: new Image(),
    leather: new Image()
};

textures.linen.src = "assets/textures/linen.png";
textures.velvet.src = "assets/textures/velvet.png";
textures.leather.src = "assets/textures/leather.png";
const canvas = document.getElementById("sofaCanvas");
const ctx = canvas.getContext("2d");


textures.linen.onload=imageLoaded;
textures.velvet.onload=imageLoaded;
textures.leather.onload=imageLoaded;
const sofaShadows = new Image();
const sofaBody = new Image();
const pillows = new Image();

sofaShadows.src = "assets/images/sofa_shadow.png";
sofaBody.src = "assets/images/sofa_body.png";
pillows.src = "assets/images/pillows.png";

let loaded = 0;

function imageLoaded() {
    loaded++;

    if(loaded===6) {

       canvas.width = sofaBody.width;
canvas.height = sofaBody.height;

        drawSofa();
    }
}

sofaShadows.onload = imageLoaded;
sofaBody.onload = imageLoaded;
pillows.onload = imageLoaded;


// -----------------------------
// Current selections
// -----------------------------

let selectedPart = "sofa_body";

let colors = {
    sofa_body: "#555555",
    pillows: "#555555"
};

let materials = {
    sofa_body: "linen",
    pillows: "linen"
};
// -----------------------------
// Draw sofa
// -----------------------------

function drawSofa(){

    ctx.clearRect(0,0,canvas.width,canvas.height);

    // Body
drawTexturedPart(
    sofaBody,
    colors.sofa_body,
    materials.sofa_body
);

drawTexturedPart(
    pillows,
    colors.pillows,
    materials.pillows
);



    // Restore original lighting
    ctx.globalCompositeOperation="multiply";

    ctx.drawImage(sofaShadows,0,0);

    ctx.globalCompositeOperation="source-over";

}
function getClickedPart(x, y){

    const temp = document.createElement("canvas");
    temp.width = canvas.width;
    temp.height = canvas.height;

    const tctx = temp.getContext("2d");

    for(let i = partMap.length-1; i>=0; i--){

        tctx.clearRect(0,0,temp.width,temp.height);

        tctx.drawImage(partMap[i].image,0,0);

        const alpha = tctx.getImageData(x,y,1,1).data[3];

        if(alpha>10){

            return partMap[i].name;

        }

    }

    return null;

}

// -----------------------------
// Paint a mask
// -----------------------------

function drawTexturedPart(mask, color, material){

    const temp = document.createElement("canvas");
    temp.width = canvas.width;
    temp.height = canvas.height;

    const tctx = temp.getContext("2d");

    // 1. Draw the texture
    const pattern = tctx.createPattern(textures[material], "repeat");
    tctx.fillStyle = pattern;
    tctx.fillRect(0,0,temp.width,temp.height);

    // 2. Tint the texture
    tctx.globalCompositeOperation = "source-atop";
    tctx.fillStyle = color;
    tctx.globalAlpha = 0.65;
    tctx.fillRect(0,0,temp.width,temp.height);

    tctx.globalAlpha = 1;

    // 3. Clip to sofa shape
    tctx.globalCompositeOperation = "destination-in";
    tctx.drawImage(mask,0,0);

    // 4. Draw on canvas
    ctx.drawImage(temp,0,0);
}

// -----------------------------
// Part selector
// -----------------------------

const selector = document.getElementById("partSelector");

selector.addEventListener("change",function(){

    selectedPart = this.value;

    document.getElementById("activePartBadge").innerText =
        this.options[this.selectedIndex].text;

});


// -----------------------------
// Color buttons
// -----------------------------

document.querySelectorAll(".color-btn").forEach(btn=>{

    btn.addEventListener("click",function(){

        document.querySelectorAll(".color-btn").forEach(b=>{
            b.classList.remove("active");
        });

        this.classList.add("active");

        const color = this.dataset.color;

        colors[selectedPart]=color;

       if(selectedPart === "sofa_body"){
    document.getElementById("sofaColor").value = color;
}else{
    document.getElementById("pillowColor").value = color;
}
        drawSofa();

    });

});


// -----------------------------
// Materials
// -----------------------------

document.querySelectorAll(".mat").forEach(btn=>{

    btn.addEventListener("click",function(){

        document.querySelectorAll(".mat").forEach(b=>{
            b.classList.remove("active");
        });

        this.classList.add("active");

        materials[selectedPart] = this.dataset.name.toLowerCase();

if(selectedPart === "sofa_body"){
    document.getElementById("sofaTexture").value = materials[selectedPart];
}else{
    document.getElementById("pillowTexture").value = materials[selectedPart];
}

drawSofa();
updatePrice();

   

        updatePrice();

        drawSofa();

    });

});


// -----------------------------
// Price
// -----------------------------

function updatePrice(){

    const base=parseFloat(document.getElementById("basePrice").value);

    const active=document.querySelector(".mat.active");

    let extra=0;

    if(active){

        extra=parseFloat(active.dataset.extra);

    }

    const total=base+extra;

    document.getElementById("totalPrice").innerHTML=
        total.toLocaleString();

    document.getElementById("finalPrice").value=total;

}
const partMap = [
    {
        name: "sofa_body",
        image: sofaBody
    },
    {
        name: "pillows",
        image: pillows
    }
];

canvas.addEventListener("mousemove",function(e){

    const rect = canvas.getBoundingClientRect();

    const scaleX=canvas.width/rect.width;
    const scaleY=canvas.height/rect.height;

    const x=(e.clientX-rect.left)*scaleX;
    const y=(e.clientY-rect.top)*scaleY;

    const part=getClickedPart(x,y);

    canvas.style.cursor=part?"pointer":"default";

});
canvas.addEventListener("click",function(e){

    const rect = canvas.getBoundingClientRect();

    const scaleX = canvas.width/rect.width;
    const scaleY = canvas.height/rect.height;

    const x = (e.clientX-rect.left)*scaleX;
    const y = (e.clientY-rect.top)*scaleY;

    const part = getClickedPart(x,y);

    if(part){

        selectedPart=part;

        document.getElementById("partSelector").value=part;

        document.getElementById("activePartBadge").innerHTML=
            part==="sofa_body"
            ? "Sofa Body"
            : "Pillows";

    }

});
updatePrice();
document.getElementById("orderForm").addEventListener("submit", function(){

    document.getElementById("sofaColor").value = colors.sofa_body;
    document.getElementById("pillowColor").value = colors.pillows;

    document.getElementById("sofaTexture").value = materials.sofa_body;
    document.getElementById("pillowTexture").value = materials.pillows;

    document.getElementById("customImage").value =
        canvas.toDataURL("image/png");

});
</script>
</body>
</html>
