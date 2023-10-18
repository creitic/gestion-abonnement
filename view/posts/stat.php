<?php $title_for_layout='Stutus'?>
<div id="generic_price_table">   
    <section>
    <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <!--PRICE HEADING START-->
                    <div class="price-heading clearfix">
                        <h1>Notre offre pro</h1>
						<p> Cette offre est faite pour les logiciels importants. 
						</p>
                    </div>
                    <!--//PRICE HEADING END-->
                </div>
            </div>
        </div>
        <div class="container">
        
            <!--BLOCK ROW START-->
            <div class="row">
            <?php foreach ($status as $k => $v): ?>    
                <div class="col-md-4">
                    <!--PRICE CONTENT START-->
                    <div class="generic_content active clearfix">
                        <!--HEAD PRICE DETAIL START-->
                        <div class="generic_head_price clearfix">
                            <!--HEAD CONTENT START-->
                            <div class="generic_head_content clearfix">
                                <!--HEAD START-->
                                <div class="head_bg"></div>
                                <div class="head">
                                    <span><?=strtoupper($v->status_nom);?></span>
                                </div>
                                <!--//HEAD END-->    
                            </div>
                            <!--//HEAD CONTENT END-->
                            
                            <!--PRICE START-->
                            <div class="generic_price_tag clearfix">    
                                <span class="price">
                                    <span class="sign">Ar</span>
                                    <span class="currency"><?=$v->prix?></span>
                                    <span class="month">/<?=$v->nbr_mois?> MOIS</span>
                                </span>
                            </div>
                            <!--//PRICE END-->
                            <div class="generic_feature_list">
                                <ul>
                                    <li><span><?=$v->nbr_mois?> mois</span> de location</li>
                                    <li><span>Plateforme</span> à louer</li>
                                    <li><span><?=$v->prix?> Ar</span> seulement</li>
                                </ul>
                            </div>
                        </div>                            
                        <!--//HEAD PRICE DETAIL END-->
                        
                        <!--BUTTON START-->
                        <?php if(empty($this->request->data)){
                            $this->request->data=new stdClass();
                        }
                        $this->request->data->fournisseur_id=$fournisseur_id;
                        $this->request->data->service_id=$service_id;
                        $this->request->data->status_id=$status_id;?>
                        <div class="generic_price_btn clearfix">
                        <?php echo $this->Form->input('fournisseur_id','hidden'); ?>
                        <?php echo $this->Form->input('service_id','hidden'); ?>
                        <?php echo $this->Form->input('status_id','hidden'); ?>
                            <a class="" href="<?php 
                            echo Router::url('posts/billposting/'.$v->fournisseur_id.'/'.$service_id.'/'.$v->status_id);?>">S'inscrire</a>
                        </div>
                        <!--//BUTTON END-->
                        
                    </div>
                    <!--//PRICE CONTENT END-->
                        
                </div>
                <?php endforeach; ?>
            </div>  
            <!--//BLOCK ROW END-->
            
        </div>

    </section>
</div