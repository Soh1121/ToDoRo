resource "aws_vpc" "this" {
	cider_block = var.vpc_cider
	enable_dns_hostnames = true
	enable_dns_support = true
	tags = {
		Name = "${local.name_prefix}-main"
	}
}
