import sys
import base64
# print(sys.argv[1])
# print(sys.argv[2])
print('\n',base64.b64decode(sys.argv[3]).decode())