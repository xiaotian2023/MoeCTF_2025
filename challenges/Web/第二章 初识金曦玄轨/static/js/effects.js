// 灵气粒子效果
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('aura-particles');
    
    for (let i = 0; i < 30; i++) {
        const particle = document.createElement('div');
        particle.className = 'aura-particle';
        
        Object.assign(particle.style, {
            width: `${Math.random() * 6 + 2}px`,
            height: `${Math.random() * 6 + 2}px`,
            background: `rgba(79,209,197,${Math.random() * 0.5 + 0.3})`,
            position: 'fixed',
            left: `${Math.random() * 100}vw`,
            top: `${Math.random() * 100}vh`,
            borderRadius: '50%',
            filter: 'blur(1px)',
            zIndex: '1'
        });
        
        container.appendChild(particle);
        animateParticle(particle);
    }
    
    function animateParticle(particle) {
        let x = parseFloat(particle.style.left);
        let y = parseFloat(particle.style.top);
        const speed = Math.random() * 0.3 + 0.1;
        
        function move() {
            y -= speed;
            if (y < -10) y = window.innerHeight + 10;
            particle.style.top = `${y}px`;
            requestAnimationFrame(move);
        }
        move();
    }
});