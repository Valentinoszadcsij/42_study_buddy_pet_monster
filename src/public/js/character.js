class Character {
    constructor(canvas) {
        this.canvas = canvas;
        this.ctx = canvas.getContext('2d');
        // Disable smoothing for pixel-perfect graphics
        this.ctx.imageSmoothingEnabled = false;
        this.spriteSheet = new Image();
        this.spriteData = null;
        this.currentFrame = 0;
        this.currentState = 'Idle';
        this.frameCount = 0;
        this.states = {
            'Idle': { from: 0, to: 4 },
            'Happy': { from: 5, to: 11 },
            'Hungry': { from: 12, to: 24 }
        };

        // Get sprite type from canvas data attribute
        this.spriteType = canvas.dataset.spriteType || 'green';
        console.log('Loading sprite type:', this.spriteType);

        // Load sprites and JSON
        this.loadAssets();
    }

    async loadAssets() {
        try {
            // Determine sprite file names based on type
            let jsonFile = '/js/sprites/mochi-green-idlehappyhungry.json';
            let pngFile = '/images/sprites/mochi-green-idlehappyhungry.png';

            if (this.spriteType === 'red') {
                jsonFile = '/js/sprites/mochi-red-idlehappyhungry.json';
                pngFile = '/images/sprites/mochi-red-idlehappyhungry.png';
            } else if (this.spriteType === 'purple') {
                jsonFile = '/js/sprites/mochi-purple-idlehappyhungry.json';
                pngFile = '/images/sprites/mochi-purple-idlehappyhungry.png';
            }

            console.log('Loading JSON:', jsonFile);
            console.log('Loading PNG:', pngFile);

            // Load sprite description JSON
            const response = await fetch(jsonFile);
            this.spriteData = await response.json();

            // Load sprite sheet image
            this.spriteSheet.src = pngFile;
            this.spriteSheet.onload = () => {
                console.log('Sprite sheet loaded successfully!');
                // Start animation after loading
                this.animate();
            };
            this.spriteSheet.onerror = () => {
                console.error('Failed to load sprite sheet:', pngFile);
            };
        } catch (error) {
            console.error('Error loading assets:', error);
        }
    }

    setState(state) {
        if (this.states[state]) {
            this.currentState = state;
            this.currentFrame = this.states[state].from;
        }
    }

    getFrameData() {
        const frameKeys = Object.keys(this.spriteData.frames);
        const frameKey = frameKeys[this.currentFrame];
        return this.spriteData.frames[frameKey];
    }

    draw() {
        if (!this.spriteData) return;

        const frameData = this.getFrameData();
        if (!frameData) return;

        // Clear canvas
        this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);

        // Calculate scale for displaying sprite at canvas size
        const scale = Math.min(
            this.canvas.width / frameData.sourceSize.w,
            this.canvas.height / frameData.sourceSize.h
        );

        // Calculate position to center the sprite
        const x = (this.canvas.width - frameData.sourceSize.w * scale) / 2;
        const y = (this.canvas.height - frameData.sourceSize.h * scale) / 2;

        // Draw current frame
        this.ctx.drawImage(
            this.spriteSheet,
            frameData.frame.x,
            frameData.frame.y,
            frameData.frame.w,
            frameData.frame.h,
            x,
            y,
            frameData.sourceSize.w * scale,
            frameData.sourceSize.h * scale
        );
    }

    animate() {
        this.frameCount++;

        // Change frame every 10 frames (approximately 150ms at 60fps)
        if (this.frameCount >= 10) {
            this.frameCount = 0;
            this.currentFrame++;

            // If we reached the end of current state animation, start over
            if (this.currentFrame > this.states[this.currentState].to) {
                this.currentFrame = this.states[this.currentState].from;
            }
        }

        this.draw();
        requestAnimationFrame(() => this.animate());
    }

    // Methods for changing character state
    makeHappy() {
        this.setState('Happy');
    }

    makeHungry() {
        this.setState('Hungry');
    }

    makeIdle() {
        this.setState('Idle');
    }
}

// Initialization
document.addEventListener('DOMContentLoaded', () => {
    const canvas = document.getElementById('characterCanvas');
    const character = new Character(canvas);

    // Add handlers for testing different states (only if buttons exist)
    const expBtn = document.querySelector('.exp-btn');
    const lvlBtn = document.querySelector('.lvl-btn');

    if (expBtn) {
        expBtn.addEventListener('click', () => character.makeHappy());
    }
    if (lvlBtn) {
        lvlBtn.addEventListener('click', () => character.makeHungry());
    }

    // Make character globally accessible for testing
    window.character = character;
});
