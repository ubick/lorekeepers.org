node['apache']['sites'].each do |name, site|
    next unless site['docroot']

    node["mysql"]["users"].each do |name, details|
        params[name + '_database_user'] ||= name
        params[name + '_database_host'] ||= details['database_host']
        params[name + '_database_name'] ||= details['database_name']
        params[name + '_database_prefix'] ||= details['database_prefix']
        params[name + '_database_password'] ||= details['password']
    end

    params['encryption_key'] = node["mysql"]["encryption_key"]

    template "#{site['docroot']}/config.php" do
        source "eqdkp.config.php.erb"
        owner "root"
        group "root"
        mode 00644
        variables({
          :params => params
        })
    end

    template "#{site['docroot']}/forums/config.php" do
        source "forum.config.php.erb"
        owner "root"
        group "root"
        mode 00644
        variables({
          :params => params
        })
    end
end