<?php
/*
 * WellCommerce Open-Source E-Commerce Platform
 *
 * This file is part of the WellCommerce package.
 *
 * (c) Adam Piotrowski <adam@wellcommerce.org>
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */
namespace WellCommerce\Bundle\ProductBundle\Form;

use WellCommerce\Bundle\CoreBundle\Form\AbstractForm;
use WellCommerce\Bundle\CoreBundle\Form\Builder\FormBuilderInterface;
use WellCommerce\Bundle\CoreBundle\Form\DataTransformer\CollectionToArrayTransformer;
use WellCommerce\Bundle\CoreBundle\Form\DataTransformer\EntityToIdentifierTransformer;
use WellCommerce\Bundle\CoreBundle\Form\FormInterface;
use WellCommerce\Bundle\MediaBundle\Form\DataTransformer\MediaEntityToIdentifierTransformer;

/**
 * Class ProductForm
 *
 * @package WellCommerce\Product\Form
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductForm extends AbstractForm implements FormInterface
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $form = $builder->init($options);

        $requiredData = $form->addChild($builder->getElement('fieldset', [
            'name'  => 'required_data',
            'label' => $this->trans('form.required_data.label')
        ]));

        $languageData = $requiredData->addChild($builder->getElement('fieldset_language', [
            'name'  => 'translations',
            'label' => $this->trans('form.required_data.language_data.label')
        ]));

        $languageData->addChild($builder->getElement('text_field', [
            'name'  => 'name',
            'label' => $this->trans('product.name'),
            'rules' => [
                $builder->getRule('required', [
                    'message' => $this->trans('Name is required')
                ]),
            ]
        ]));

        $mediaData = $form->addChild($builder->getElement('fieldset', [
            'name'  => 'media_data',
            'label' => $this->trans('fieldset.media')
        ]));

        $mediaData->addChild($builder->getElement('image', [
            'name'        => 'photo',
            'label'       => $this->trans('form.media_data.image_id'),
            'load_route'  => $this->generateUrl('admin.media.grid'),
            'upload_url'  => $this->generateUrl('admin.media.add'),
            'repeat_min'  => 0,
            'repeat_max'  => 1,
            'transformer' => new MediaEntityToIdentifierTransformer($this->get('media.repository'))
        ]));

        $delivererData = $form->addChild($builder->getElement('fieldset', [
            'name'  => 'deliverers_data',
            'label' => $this->trans('product.deliverers')
        ]));

        $delivererData->addChild($builder->getElement('multi_select', [
            'name'        => 'deliverers',
            'label'       => $this->trans('deliverers'),
            'options'     => $this->get('deliverer.repository')->getCollectionToSelect(),
            'transformer' => new CollectionToArrayTransformer($this->get('deliverer.repository'))
        ]));

        $shopData = $form->addChild($builder->getElement('fieldset', [
            'name'  => 'shop_data',
            'label' => $this->trans('shops')
        ]));

        $shopData->addChild($builder->getElement('multi_select', [
            'name'        => 'shops',
            'label'       => $this->trans('shops'),
            'options'     => $this->get('shop.repository')->getCollectionToSelect(),
            'transformer' => new CollectionToArrayTransformer($this->get('shop.repository'))
        ]));

        $form->addFilter('no_code');
        $form->addFilter('trim');
        $form->addFilter('secure');

        return $form;
    }
}
