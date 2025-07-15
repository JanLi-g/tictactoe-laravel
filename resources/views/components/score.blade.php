<div id="score-{{ strtolower($player) }}"
     class="score {{ $player === 'X' ? 'scoreX' : 'scoreO' }}{{ $active ? ' active' : '' }}">
    <img src="/svg/{{ strtolower($player) }}-solid.svg" alt="{{ $player }}" style="width: 32px; height: 32px;">
    <span style="display: flex; align-items: center; gap: 0.5rem;">
        <span class="{{ $player === 'X' ? 'scoreX' : 'scoreO' }}">{{ $player }}:</span>
        <span class="{{ $player === 'X' ? 'scoreX' : 'scoreO' }}">{{ $score }}</span>
    </span>
</div>
