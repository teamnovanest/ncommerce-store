# Contains different setups for deploying admin app to prod 

deploy_test:
	gcloud app deploy app-test.yaml --version  20210606t210358 --no-promote  --project vestashi-com

deploy_prod:
	gcloud app deploy app-prod.yaml  --project  vestashi-two-com 

deploy_dispatch:
	gcloud app deploy dispatch.yaml --project  vestashi-two-com 

deploy_prod_no_promote:
	gcloud app deploy app-prod.yaml  --project  vestashi-two-com --no-promote

deploy_new_version:
	gcloud app deploy app-prod.yaml --no-promote  --project vestashi-com
