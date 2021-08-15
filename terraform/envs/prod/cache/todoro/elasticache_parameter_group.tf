resource "aws_elasticache_parameter_group" "this" {
  name = "${local.service_name}-${local.env_name}-${local.service_name}"

  family = "redis6.x"
}
