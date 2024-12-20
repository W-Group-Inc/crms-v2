<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class PriceRequestProduct extends Model
{
    use SoftDeletes;
    protected $table = "pricerequestproducts";
    // protected $primaryKey = "Id";

    const UPDATED_AT = "ModifiedDate";
    const CREATED_AT = "CreatedDate";

    protected $fillable = [
        'PriceRequestFormId','Type', 'QuantityRequired', 'ProductId', 'ProductRmc', 'IsalesShipmentCost', 'IsalesFinancingCost', 'IsalesOthers', 'IsalesTotalBaseCost',
        'IsalesBaseSellingPrice', 'IsalesOfferedPrice', 'IsalesMargin', 'IsalesMarginPercentage', 'ApplicationId', 'LsalesDirectLabor', 'LsalesFactoryOverhead',
        'LsalesBlendingLoss', 'LsalesDeliveryType', 'LsalesDeliveryCost', 'LsalesFinancingCost', 'PriceRequestGaeId', 'LsalesGaeValue', 'LsalesMarkupPercent',
        'LsalesMarkupValue', 'OtherCostRequirements'
    ];
    public function client()
    {
        return $this->belongsTo(Client::class, 'ClientId', 'id');
    }

    public function product_application() 
    {
        return $this->belongsTo(ProductApplication::class, 'ApplicationId', 'id');
    }

    public function products() 
    {
        return $this->belongsTo(Product::class, 'ProductId', 'id');
    }
    
    public function progressStatus()
    {
        return $this->belongsTo(SrfProgress::class, 'Progress', 'id');
    }
    public function gaeType()
    {
        return $this->belongsTo(PriceRequestGae::class, 'PriceRequestGaeId', 'id');
    }
    public function priceRequestForm()
    {
        return $this->belongsTo(PriceMonitoring::class,'PriceRequestFormId');
    }
}
