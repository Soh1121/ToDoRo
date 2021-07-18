module "nginx" {
  source = "../../../../modules/ecr"

  name = "${local.name_prefix}-nginx"
}

module "php" {
  source = "../../../../modules/ecr"

  name = "${local.name_prefix}-php"
}
