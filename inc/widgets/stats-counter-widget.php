<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class Personal_Site_Stats_Counter_Widget extends \Elementor\Widget_Base {

    public function get_name(): string       { return 'personal_site_stats_counter'; }
    public function get_title(): string      { return esc_html__( 'Stats Counter', 'personal-site' ); }
    public function get_icon(): string       { return 'eicon-counter'; }
    public function get_categories(): array  { return [ 'personal-site' ]; }
    public function get_keywords(): array    { return [ 'stats', 'counter', 'numbers', 'achievements' ]; }

    protected function register_controls(): void {

        $this->start_controls_section( 'section_stats', [
            'label' => esc_html__( 'Stats', 'personal-site' ),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control( 'number', [
            'label'   => esc_html__( 'Number', 'personal-site' ),
            'type'    => \Elementor\Controls_Manager::NUMBER,
            'default' => 100,
        ] );

        $repeater->add_control( 'suffix', [
            'label'   => esc_html__( 'Suffix (e.g. +, %)', 'personal-site' ),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => '+',
        ] );

        $repeater->add_control( 'label', [
            'label'   => esc_html__( 'Label', 'personal-site' ),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => esc_html__( 'Successful Projects', 'personal-site' ),
        ] );

        $this->add_control( 'stats', [
            'label'       => esc_html__( 'Stats Items', 'personal-site' ),
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'default'     => [
                [ 'number' => 11,  'suffix' => '+',  'label' => 'Years Experience' ],
                [ 'number' => 100, 'suffix' => '+',  'label' => 'Successful Projects' ],
                [ 'number' => 97,  'suffix' => '%',  'label' => 'Satisfied Clients' ],
            ],
            'title_field' => '{{{ number }}}{{{ suffix }}} — {{{ label }}}',
        ] );

        $this->add_control( 'count_duration', [
            'label'   => esc_html__( 'Count Duration (ms)', 'personal-site' ),
            'type'    => \Elementor\Controls_Manager::NUMBER,
            'default' => 1800,
            'min'     => 500,
            'max'     => 5000,
        ] );

        $this->end_controls_section();

        // Style
        $this->start_controls_section( 'section_style', [
            'label' => esc_html__( 'Style', 'personal-site' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'number_color', [
            'label'     => esc_html__( 'Number Color', 'personal-site' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => [
                '{{WRAPPER}} .ps-stat__number' => 'color: {{VALUE}};',
            ],
        ] );

        $this->add_control( 'label_color', [
            'label'     => esc_html__( 'Label Color', 'personal-site' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => 'oklch(82% 0.008 60)',
            'selectors' => [
                '{{WRAPPER}} .ps-stat__label' => 'color: {{VALUE}};',
            ],
        ] );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'number_typography',
                'selector' => '{{WRAPPER}} .ps-stat__number',
            ]
        );

        $this->end_controls_section();
    }

    protected function render(): void {
        $s        = $this->get_settings_for_display();
        $stats    = $s['stats'] ?? [];
        $duration = intval( $s['count_duration'] ?? 1800 );
        $uid      = 'ps-stats-' . $this->get_id();
        ?>
        <div class="ps-stats" id="<?php echo esc_attr( $uid ); ?>">
            <?php foreach ( $stats as $item ) : ?>
            <div class="ps-stat glass"
                 data-target="<?php echo esc_attr( $item['number'] ); ?>"
                 data-suffix="<?php echo esc_attr( $item['suffix'] ); ?>"
                 data-duration="<?php echo esc_attr( $duration ); ?>">
                <div class="ps-stat__number" aria-live="polite">
                    <span class="ps-stat__count">0</span><?php echo esc_html( $item['suffix'] ); ?>
                </div>
                <p class="ps-stat__label"><?php echo esc_html( $item['label'] ); ?></p>
            </div>
            <?php endforeach; ?>
        </div>

        <style>
        .ps-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 1rem;
            padding: 2rem 0;
        }
        .ps-stat {
            padding: 2rem 1.5rem;
            text-align: center;
            transition: transform var(--transition-base);
        }
        .ps-stat:hover { transform: translateY(-4px); }
        .ps-stat__number {
            font-size: clamp(2.2rem, 5vw, 3.5rem);
            font-weight: 800;
            letter-spacing: -0.03em;
            line-height: 1;
            margin-bottom: 0.5rem;
        }
        .ps-stat__label {
            font-size: 0.85rem;
            opacity: 0.65;
        }
        </style>

        <script>
        (function() {
            var uid = <?php echo json_encode( '#' . $uid ); ?>;
            var section = document.querySelector(uid);
            if (!section) return;

            function easeOut(t) { return t * (2 - t); }

            function animateStat(el) {
                var target   = parseInt(el.dataset.target, 10);
                var duration = parseInt(el.dataset.duration, 10);
                var countEl  = el.querySelector('.ps-stat__count');
                var start    = null;

                function step(ts) {
                    if (!start) start = ts;
                    var progress = Math.min((ts - start) / duration, 1);
                    countEl.textContent = Math.floor(easeOut(progress) * target);
                    if (progress < 1) requestAnimationFrame(step);
                    else countEl.textContent = target;
                }
                requestAnimationFrame(step);
            }

            // Respect reduced-motion
            var prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

            if (prefersReduced) {
                section.querySelectorAll('.ps-stat').forEach(function(el) {
                    var countEl = el.querySelector('.ps-stat__count');
                    countEl.textContent = el.dataset.target;
                });
                return;
            }

            var observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        animateStat(entry.target);
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.3 });

            section.querySelectorAll('.ps-stat').forEach(function(el) {
                observer.observe(el);
            });
        })();
        </script>
        <?php
    }
}
