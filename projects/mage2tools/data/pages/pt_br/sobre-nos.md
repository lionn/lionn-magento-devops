
<section class="m2tools-sobrenos-container">

    <div class="m2tools-item -sobre">
        <div class="m2tools-descricao">
            <h3 class="m2tools-subtitulo">Sobre Nós</h3>
            <p>Descrição sobre o projeto.</p>
        </div>

        <div class="m2tools-imagem">
            <picture>
                <source srcset="{{view url='images/pages/sobrenos-img001.png'}} 1x, {{view url='images/pages/sobrenos-x2-img001.png'}} 2x" media="(min-width: 1440px)">
                <img src="{{view url='images/pages/sobrenos-img002.png'}}" alt="Sobre o Mage2Tools">
            </picture>
        </div>
    </div>

    <div class="m2tools-item cms-content-important -missao">
        <div class="m2tools-imagem">
            <picture>
                <source srcset="{{view url='images/pages/sobrenos-img003.png'}} 1x, {{view url='images/pages/sobrenos-x2-img002.png'}} 2x" media="(min-width: 1440px)">
                <img src="{{view url='images/pages/sobrenos-img004.png'}}" alt="Missão do Mage2Tools">
            </picture>
        </div>

        <div class="m2tools-descricao">
            <h3 class="m2tools-subtitulo">Nossa Missão</h3>
            <p>Descrição da missão do projeto.</p>
        </div>
    </div>

</section>

<p>{{widget type="Magento\Cms\Block\Widget\Block" template="widget/static_block/default.phtml" block_id="m2tools-explore-mais"}}</p>
