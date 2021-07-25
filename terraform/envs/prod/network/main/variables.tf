variable "vpc_cider" {
	type = string
	default = "172.32.0.0/16"
}

variable "azs" {
  type = map(object({
	  public_cidr = string
	  private_cidr = string
  }))
  default = {
    a = {
      public_cidr = "172.32.0.0/20"
      private_cidr = "172.32.48.0/20"
    },
    c = {
	    public_cidr = "172.32.16.0/20"
	    private_cidr = "172.32.64.0/20"
    }
  }
}
