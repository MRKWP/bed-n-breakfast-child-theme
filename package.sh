plugin_basename=$(basename $(pwd))

#clean up
rm -rf /tmp/$plugin_basename || true;
rm /tmp/$plugin_basename.zip || true;

mkdir -p /tmp/$plugin_basename;

cd ..;
cp -r $plugin_basename /tmp;

cd -;
cd /tmp;

zip -r9 $plugin_basename.zip $plugin_basename -x *.git* -x *.sh -x *.json -x *.github* -x *node_modules* -x *grunt* -x *gulpfile.js* -x *styles*> /dev/null;
rm -rf /tmp/$plugin_basename;

echo "Copied file to /tmp/$plugin_basename.zip"

rclone mkdir df-s3:diviframework/$plugin_basename;
rclone copy /tmp/$plugin_basename.zip df-s3:diviframework/$plugin_basename;
echo "https://s3-ap-southeast-2.amazonaws.com/diviframework/$plugin_basename/$plugin_basename.zip"