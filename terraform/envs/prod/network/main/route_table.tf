resource "aws_route_table" "public" {
  vpc_id = aws_vpc.this.id

  tags = {
	  Name = "${aws_vpc.this.tags.Name}-public"
  }
}

resource "aws_route" "internet_gateway_public" {
  destination_cidr_block = "0.0.0.0/0"
  gateway_id = aws_internet_gateway.this.id
  route_table_id = aws_route_table.public.id
}

resource "aws_route_table_association" "public" {
	for_each = var.azs

	route_table_id = aws_route_table.public.id
	subnet_id = aws_subnet.public[each.key].id
}
