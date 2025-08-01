<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/shopping/merchant/reviews/v1beta/merchantreviews.proto

namespace GPBMetadata\Google\Shopping\Merchant\Reviews\V1Beta;

class Merchantreviews
{
    public static $is_initialized = false;

    public static function initOnce() {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();

        if (static::$is_initialized == true) {
          return;
        }
        \GPBMetadata\Google\Api\Annotations::initOnce();
        \GPBMetadata\Google\Api\Client::initOnce();
        \GPBMetadata\Google\Api\FieldBehavior::initOnce();
        \GPBMetadata\Google\Api\Resource::initOnce();
        \GPBMetadata\Google\Protobuf\GPBEmpty::initOnce();
        \GPBMetadata\Google\Shopping\Merchant\Reviews\V1Beta\MerchantreviewsCommon::initOnce();
        \GPBMetadata\Google\Shopping\Type\Types::initOnce();
        $pool->internalAddGeneratedFile(
            '
�
=google/shopping/merchant/reviews/v1beta/merchantreviews.proto\'google.shopping.merchant.reviews.v1betagoogle/api/client.protogoogle/api/field_behavior.protogoogle/api/resource.protogoogle/protobuf/empty.protoDgoogle/shopping/merchant/reviews/v1beta/merchantreviews_common.proto google/shopping/type/types.proto"[
GetMerchantReviewRequest?
name (	B1�A�A+
)merchantapi.googleapis.com/MerchantReview"^
DeleteMerchantReviewRequest?
name (	B1�A�A+
)merchantapi.googleapis.com/MerchantReview"�
ListMerchantReviewsRequestA
parent (	B1�A�A+)merchantapi.googleapis.com/MerchantReview
	page_size (B�A

page_token (	B�A"�
InsertMerchantReviewRequest
parent (	B�AU
merchant_review (27.google.shopping.merchant.reviews.v1beta.MerchantReviewB�A
data_source (	B�A"�
ListMerchantReviewsResponseQ
merchant_reviews (27.google.shopping.merchant.reviews.v1beta.MerchantReview
next_page_token (	"�
MerchantReview
name (	B�A
merchant_review_id (	B�Aj
merchant_review_attributes (2A.google.shopping.merchant.reviews.v1beta.MerchantReviewAttributesB�AE
custom_attributes (2%.google.shopping.type.CustomAttributeB�A
data_source (	B�Ab
merchant_review_status (2=.google.shopping.merchant.reviews.v1beta.MerchantReviewStatusB�A:z�Aw
)merchantapi.googleapis.com/MerchantReview)accounts/{account}/merchantReviews/{name}*merchantReviews2merchantReview2�
MerchantReviewsService�
GetMerchantReviewA.google.shopping.merchant.reviews.v1beta.GetMerchantReviewRequest7.google.shopping.merchant.reviews.v1beta.MerchantReview"B�Aname���53/reviews/v1beta/{name=accounts/*/merchantReviews/*}�
ListMerchantReviewsC.google.shopping.merchant.reviews.v1beta.ListMerchantReviewsRequestD.google.shopping.merchant.reviews.v1beta.ListMerchantReviewsResponse"D�Aparent���53/reviews/v1beta/{parent=accounts/*}/merchantReviews�
InsertMerchantReviewD.google.shopping.merchant.reviews.v1beta.InsertMerchantReviewRequest7.google.shopping.merchant.reviews.v1beta.MerchantReview"S���M":/reviews/v1beta/{parent=accounts/*}/merchantReviews:insert:merchant_review�
DeleteMerchantReviewD.google.shopping.merchant.reviews.v1beta.DeleteMerchantReviewRequest.google.protobuf.Empty"B�Aname���5*3/reviews/v1beta/{name=accounts/*/merchantReviews/*}G�Amerchantapi.googleapis.com�A\'https://www.googleapis.com/auth/contentB�
+com.google.shopping.merchant.reviews.v1betaBMerchantReviewsProtoPZKcloud.google.com/go/shopping/merchant/reviews/apiv1beta/reviewspb;reviewspb�\'Google.Shopping.Merchant.Reviews.V1Beta�\'Google\\Shopping\\Merchant\\Reviews\\V1beta�+Google::Shopping::Merchant::Reviews::V1beta�A8
"merchantapi.googleapis.com/Accountaccounts/{account}bproto3'
        , true);

        static::$is_initialized = true;
    }
}

