import * as THREE from "https://cdn.skypack.dev/three@0.128.0";
import { RoundedBoxGeometry } from "https://cdn.skypack.dev/three@0.128.0/examples/jsm/geometries/RoundedBoxGeometry.js";

document.addEventListener("DOMContentLoaded", function () {
  // Responsive Container Logic
  function getResponsiveContainer() {
    // 768px matches Tailwind's 'md' breakpoint
    if (window.innerWidth < 768) {
      return document.getElementById("quadra-3d-mobile");
    } else {
      return document.getElementById("quadra-3d-desktop");
    }
  }

  let currentContainer = getResponsiveContainer();
  // Safe exit if neither container exists
  if (!currentContainer) {
    console.warn("Quadra 3D: No container found.");
    return;
  }

  // Scene Setup
  const scene = new THREE.Scene();
  scene.background = null;

  // Camera Setup
  const camera = new THREE.PerspectiveCamera(
    45,
    currentContainer.clientWidth / currentContainer.clientHeight,
    0.1,
    100
  );
  camera.position.set(5, 5, 5);
  camera.lookAt(0, 0, 0);

  // Renderer Setup
  const renderer = new THREE.WebGLRenderer({
    alpha: true,
    antialias: true,
  });
  renderer.setPixelRatio(window.devicePixelRatio);
  renderer.shadowMap.enabled = true;
  renderer.shadowMap.type = THREE.PCFSoftShadowMap;

  // Append to initial container
  currentContainer.appendChild(renderer.domElement);

  // Responsive Resize Function
  function updateSize() {
    const newContainer = getResponsiveContainer();

    // If container context changes (e.g. mobile <-> desktop)
    if (newContainer && newContainer !== currentContainer) {
      newContainer.appendChild(renderer.domElement);
      currentContainer = newContainer;
    }

    if (currentContainer) {
      const width = currentContainer.clientWidth;
      const height = currentContainer.clientHeight;

      // Only update if dimensions are valid
      if (width > 0 && height > 0) {
        camera.aspect = width / height;
        camera.updateProjectionMatrix();
        renderer.setSize(width, height);
      }
    }
  }

  // Initial size set
  updateSize();
  window.addEventListener("resize", updateSize);

  // Groups Structure
  const tiltGroup = new THREE.Group();
  scene.add(tiltGroup);

  const autoRotationGroup = new THREE.Group();
  tiltGroup.add(autoRotationGroup);

  // Layer Groups for Rubik's-like rotation
  const topLayer = new THREE.Group();
  const middleLayer = new THREE.Group();
  const bottomLayer = new THREE.Group();

  autoRotationGroup.add(topLayer);
  autoRotationGroup.add(middleLayer);
  autoRotationGroup.add(bottomLayer);

  // Geometries
  // Uniform rounded box for a cohesive premium look
  // Geometries
  // Sharper radius to match the reference "tech" look -> Adjusted to semi-sharp
  const geometry = new RoundedBoxGeometry(1.0, 1.0, 1.0, 4, 0.08);

  // Material: Dark Iridescent Metal
  const matIridescent = new THREE.MeshPhysicalMaterial({
    color: 0x151515, // Lighter blackish base
    roughness: 0.1, // Highly polished
    metalness: 0.95,
    clearcoat: 1.0, // High polish
    clearcoatRoughness: 0.05, // Ultra smooth clearcoat
    reflectivity: 1.0,
  });

  // Create 3x3x3 Grid
  const gridSize = 3;
  const offset = (gridSize - 1) / 2;

  for (let x = 0; x < gridSize; x++) {
    for (let y = 0; y < gridSize; y++) {
      for (let z = 0; z < gridSize; z++) {
        // Use the unified shiny material
        const mesh = new THREE.Mesh(geometry, matIridescent);

        // Position spaced by 1.01 for tiny gaps (aesthetic line)
        const px = (x - offset) * 1.02;
        const py = (y - offset) * 1.02;
        const pz = (z - offset) * 1.02;

        mesh.position.set(px, py, pz);
        mesh.castShadow = true;
        mesh.receiveShadow = true;

        if (y === 0) {
          bottomLayer.add(mesh);
        } else if (y === 1) {
          middleLayer.add(mesh);
        } else {
          topLayer.add(mesh);
        }
      }
    }
  }

  // Shadow: Fake Shadow Plane (Enhanced for Darker visual)
  const canvas = document.createElement("canvas");
  canvas.width = 128; // Low res is fine for a soft blur
  canvas.height = 128;
  const context = canvas.getContext("2d");

  // Stronger, more diffused gradient
  const gradient = context.createRadialGradient(64, 64, 0, 64, 64, 64);
  gradient.addColorStop(0, "rgba(0,0,0,0.8)"); // Dark core
  gradient.addColorStop(0.4, "rgba(0,0,0,0.4)"); // Mid soft spread
  gradient.addColorStop(1, "rgba(0,0,0,0)"); // Fade out

  context.fillStyle = gradient;
  context.fillRect(0, 0, 128, 128);

  const shadowTexture = new THREE.CanvasTexture(canvas);
  const shadowMaterial = new THREE.MeshBasicMaterial({
    map: shadowTexture,
    transparent: true,
    opacity: 0.8, // Higher base opacity
    depthWrite: false, // Don't write to depth buffer (no occlusion issues)
  });
  const shadowPlane = new THREE.Mesh(
    new THREE.PlaneGeometry(6, 6), // Slightly larger spread
    shadowMaterial
  );
  shadowPlane.rotation.x = -Math.PI / 2;
  shadowPlane.position.y = -2.2; // Slightly lower to clear the cube movement
  scene.add(shadowPlane);

  // Lighting - Cyberpunk Gradient Setup

  // Ambient - Low to keep blacks deep
  const ambientLight = new THREE.AmbientLight(0x111111, 1.0);
  scene.add(ambientLight);

  // Key Light (Main White/Blueish Highlight)
  const keyLight = new THREE.DirectionalLight(0xffffff, 1.0);
  keyLight.position.set(-5, 8, 8);
  keyLight.castShadow = true;
  keyLight.shadow.mapSize.width = 1024;
  keyLight.shadow.mapSize.height = 1024;
  scene.add(keyLight);

  // Purple Shine (From Top/Right)
  const purpleLight = new THREE.PointLight(0xaa00ff, 3.0, 20);
  purpleLight.position.set(5, 5, 5);
  scene.add(purpleLight);

  // Cyan Shine (From Bottom/Left)
  const cyanLight = new THREE.PointLight(0x00aaff, 3.0, 20);
  cyanLight.position.set(-5, -2, 2);
  scene.add(cyanLight);

  // Rim Light (Back)
  const rimLight = new THREE.DirectionalLight(0xffffff, 1.0); // White rim for edge definition
  rimLight.position.set(0, 5, -10);
  scene.add(rimLight);

  // Mouse Interaction (Manual Drag Rotation with Smoothness)
  let isDragging = false;
  let previousMousePosition = { x: 0, y: 0 };
  let targetRotation = { x: 0, y: 0 }; // For smooth interpolation

  // Listeners attached to the renderer's canvas
  renderer.domElement.addEventListener("mousedown", (e) => {
    isDragging = true;
    previousMousePosition = { x: e.offsetX, y: e.offsetY };
  });

  window.addEventListener("mouseup", () => {
    isDragging = false;
  });

  renderer.domElement.addEventListener("mousemove", (e) => {
    if (isDragging) {
      const deltaMove = {
        x: e.offsetX - previousMousePosition.x,
        y: e.offsetY - previousMousePosition.y,
      };
      // cursor speed
      const baseSpeed = 0.005;
      const rotateSpeed = baseSpeed * 2;

      // Update target rotation input
      targetRotation.y += deltaMove.x * rotateSpeed;
      targetRotation.x += deltaMove.y * rotateSpeed;
    }

    previousMousePosition = {
      x: e.offsetX,
      y: e.offsetY,
    };
  });

  // Touch Support (Mobile)
  renderer.domElement.addEventListener(
    "touchstart",
    (e) => {
      if (e.touches.length === 1) {
        isDragging = true;
        previousMousePosition = {
          x: e.touches[0].clientX,
          y: e.touches[0].clientY,
        };
      }
    },
    { passive: false }
  );

  renderer.domElement.addEventListener(
    "touchmove",
    (e) => {
      if (isDragging && e.touches.length === 1) {
        e.preventDefault(); // Prevent scrolling while rotating

        const deltaMove = {
          x: e.touches[0].clientX - previousMousePosition.x,
          y: e.touches[0].clientY - previousMousePosition.y,
        };

        const baseSpeed = 0.005;
        const rotateSpeed = baseSpeed * 1.2;

        targetRotation.y += deltaMove.x * rotateSpeed;
        targetRotation.x += deltaMove.y * rotateSpeed;

        previousMousePosition = {
          x: e.touches[0].clientX,
          y: e.touches[0].clientY,
        };
      }
    },
    { passive: false }
  );

  window.addEventListener("touchend", () => {
    isDragging = false;
  });

  // Easing function for smooth rotation
  function easeInOutCubic(t) {
    return t < 0.5 ? 4 * t * t * t : 1 - Math.pow(-2 * t + 2, 3) / 2;
  }

  // Animation Loop
  const clock = new THREE.Clock();

  // Animation State
  // Cycle: Pause -> Top Rotate -> Pause -> Bottom Rotate
  // Duration config (Seconds)
  const pauseDuration = 0.5;
  const rotateDuration = 1.0;
  const totalCycle = (pauseDuration + rotateDuration) * 2;

  // Track accumulated rotations (90 degrees / PI/2 per move)
  const quarterTurn = Math.PI / 2;

  function animate() {
    requestAnimationFrame(animate);

    const delta = clock.getDelta();
    const time = clock.getElapsedTime();

    // 1. Sequenced Layer Rotation Logic
    // We base the rotation on the total elapsed time to keep it synced
    const cycleTime = time % totalCycle;

    // Determine overall rotation counts based on full cycles completed
    const fullCycles = Math.floor(time / totalCycle);
    const baseRotation = fullCycles * quarterTurn;

    let targetTop = baseRotation;
    let targetBottom = baseRotation;

    // Phase 1: Initial Pause (0 to pauseDuration)
    // No change

    // Phase 2: Top Rotate (pauseDuration to pauseDuration + rotateDuration)
    if (
      cycleTime > pauseDuration &&
      cycleTime <= pauseDuration + rotateDuration
    ) {
      const t = (cycleTime - pauseDuration) / rotateDuration;
      const eased = easeInOutCubic(t);
      // Top rotates Left to Right (Negative Y)
      targetTop -= eased * quarterTurn;

      // Ensure accumulated rotation from previous cycles
      // For continuous effect, we might need a simpler progressive logic
      // Let's use simpler logic: maintain state manually
    }

    // Actually, explicit state is easier than calculating from total time for infinite accumulating rotations.
    // Let's implement a clean state sequencer.
  }

  // Clean Sequencer vars
  let seqPhase = 0; // 0: Top, 1: Pause1, 2: Bottom, 3: Pause2
  let seqTimer = 0;
  let currentTopRot = 0;
  let targetTopRot = 0;
  let currentBotRot = 0;
  let targetBotRot = 0;

  // We want to rotate "Once" per phase, meaning 90 degrees.
  const ROT_AMOUNT = Math.PI / 2;

  function animateSequence(dt) {
    seqTimer += dt;

    // Linear Interpolation factor for smoothness
    const lerpSpeed = 5 * dt;

    if (seqPhase === 0) {
      // Rotate Top (Left -> Right = -Y)
      targetTopRot = currentTopRot - ROT_AMOUNT; // Set target
      if (seqTimer > rotateDuration) {
        currentTopRot = targetTopRot; // Snap to exact to avoid drift
        topLayer.rotation.y = currentTopRot;
        seqPhase = 1;
        seqTimer = 0;
      } else {
        // Animate towards target
        // Use smoothstep based on timer progress for uniform speed
        const progress = seqTimer / rotateDuration;
        const ease = easeInOutCubic(progress);
        topLayer.rotation.y = currentTopRot - ease * ROT_AMOUNT;
      }
    } else if (seqPhase === 1) {
      // Pause
      if (seqTimer > pauseDuration) {
        seqPhase = 2;
        seqTimer = 0;
      }
    } else if (seqPhase === 2) {
      // Rotate Bottom (Right -> Left = +Y)
      targetBotRot = currentBotRot + ROT_AMOUNT;
      if (seqTimer > rotateDuration) {
        currentBotRot = targetBotRot;
        bottomLayer.rotation.y = currentBotRot;
        seqPhase = 3;
        seqTimer = 0;
      } else {
        const progress = seqTimer / rotateDuration;
        const ease = easeInOutCubic(progress);
        bottomLayer.rotation.y = currentBotRot + ease * ROT_AMOUNT;
      }
    } else if (seqPhase === 3) {
      // Pause
      if (seqTimer > pauseDuration) {
        // Reset for next cycle
        // We update "current" references to match where we ended up
        // topLayer.rotation.y and bottomLayer.rotation.y are already at +/- N * PI/2
        // We just start the next move relative to that.
        seqPhase = 0;
        seqTimer = 0;
      }
    }
  }

  function renderLoop() {
    requestAnimationFrame(renderLoop);

    const delta = clock.getDelta();
    const time = clock.getElapsedTime();

    // Run the sequencer
    animateSequence(delta);

    // 2. Global Group Movement (Levitation & 360 Rotation)
    // Continuous rotation on all axes for omni-directional spin (Slower)
    autoRotationGroup.rotation.y += delta * 0.8;
    autoRotationGroup.rotation.x += delta * 0.6;
    autoRotationGroup.rotation.z += delta * 0.4;

    // Levitation
    const levitation = Math.sin(time * 1.5) * 0.15;
    tiltGroup.position.y = levitation;

    // Shadow breathing
    const shadowScale = 1 - levitation * 0.2;
    shadowPlane.scale.set(shadowScale, shadowScale, shadowScale);
    shadowPlane.material.opacity = 0.6 - levitation * 0.15;

    // Smooth Manual Rotation (Inertia)
    // Lerp towards the target rotation set by dragging
    const damping = 0.1;
    tiltGroup.rotation.x += (targetRotation.x - tiltGroup.rotation.x) * damping;
    tiltGroup.rotation.y += (targetRotation.y - tiltGroup.rotation.y) * damping;

    renderer.render(scene, camera);
  }

  renderLoop();
});
