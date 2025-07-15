<div id="score-{{ strtolower($player) }}" class="score {{ (isset($active) && $active) ? 'active' : '' }}">
    {{ $player }}: <span class="score-value">{{ $score }}</span>
</div>
