<div id="score-{{ strtolower($player) }}"
     style="display: flex; align-items: center; gap: 0.5rem; padding: 1rem 2rem; border-radius: 12px; font-size: 1.5rem; font-weight: 600; box-shadow: 0 2px 8px #0002; transition: all 0.2s;"
    {{ $active ? 'class=active' : '' }}
    {{ $active ? 'style=background:#e3f0ff; border:2px solid #1976d2; color:#1976d2;' : '' }}>
    <img src="/svg/{{ strtolower($player) }}-solid.svg" alt="{{ $player }}" style="width: 32px; height: 32px;">
    <span>{{ $player }}: {{ $score }}</span>
</div>
