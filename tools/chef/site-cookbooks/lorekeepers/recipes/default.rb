package "php" do
  action :remove
end

package "php-common" do
  action :remove
end

mysql_service 'default' do
  port '3306'
  version '5.7'
  initial_root_password node["mysql"]["connections"]["default"]["password"]
  action [:create, :start]
end

mysql_client 'default' do
  version '5.7'
  action :create
end