# TODO 0: Mempersiapkan library minio, pymongo, dan pandas 
from minio import Minio
from minio.select import (CSVInputSerialization, CSVOutputSerialization, SelectRequest)
import pymongo
import pandas as pd


print("______________________________________\n")
# TODO 1: Set environment variabel
server = "127.0.0.1:9000"
accessKey = "minioadmin"
secretKey = "minioadmin"
myBucket = "bigdata"
dataset = "dataset/googleplaystore.csv"
myObject = "datasetgoogleplaystore"


print("______________________________________\n")
# TODO 2: Mempersiapkan koneksi ke API Minio
client = Minio(
    server,
    access_key= accessKey,
    secret_key= secretKey,
    secure = False
)
print("Terhubung ke minio server: " + server)


print("______________________________________\n")
# TODO 3: Membuat bukcet minio
if client.bucket_exists(myBucket):
	print("Bucket \'" + myBucket + "\' telah tersedia!")
else:
    # Membuat bukcet baru
    client.make_bucket(myBucket)
    print("Bucket \'" + myBucket + "\' berhasil dibuat!\n")


print("______________________________________\n")
# TODO 4: Upload dataset/ object ke minio server
result = client.fput_object(myBucket, myObject, dataset, content_type="application/csv",)

print(
    "Object \' {0} \' berhasil disimpan!; etag: {1}, version-id: {2}".format(
        result.object_name, result.etag, result.version_id,
    ),
)

print("______________________________________\n")
# TODO 5: Menampilkan object dari minio server dalam pandas df
try:
    response = client.get_object(myBucket, myObject)
    hasil = pd.read_csv(response)
    print(hasil)
finally:
    response.close()
    response.release_conn()


print("______________________________________\n")
# TODO 6: Mempersiapkan koneksi ke API MongoDB
#buat koneksi ke server MongoDB
clientMongo = pymongo.MongoClient("mongodb://localhost:27017")
#buat database baru atau buka jika sudah ada
db = clientMongo["dbGooglePlayStore"]
#buat collection atau buka jika sudah ada
col = db["colGooglePlayStore"]

try: db.command("serverStatus")
except Exception as e: print(e)
else: print("Terhubung ke mongodb server!")

print("______________________________________\n")
# TODO 7: Mengirimkan object Minio ke MongoDB
response = client.get_object(myBucket, myObject)
data = pd.DataFrame(pd.read_csv(response))
data = data.to_dict(orient="records")
col.insert_many(data)

if col.inserted_ids is not None:
    print("Object berhasil disimpan di mongoDB!")
else:
    print("Object gagal disimpan di mongoDB!")