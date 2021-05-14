## Summary:


## Pod file
```yaml
apiVersion: v1
kind: Pod
metadata:
  name: demo
spec:
  containers:
  - name: testpod
    image: alpine:3.5
    command: ["ping", "8.8.8.8"]
```

## Commands

```bash
# Create a pod
kubectl apply -f pod.yaml

# List pods
kubectl get pods

# Show logs
kubectl logs demo

# Delete a pod
kubectl delete -f pod.yaml

```

## Pod file
```yaml
apiVersion: apps/v1
kind: Deployment
metadata:
  name: bb-demo
  namespace: default
spec:
  replicas: 1
  selector:
    matchLabels:
      bb: web
  template:
    metadata:
      labels:
        bb: web
    spec:
      containers:
      - name: bb-site
        image: bulletinboard:1.0
---
apiVersion: v1
kind: Service
metadata:
  name: bb-entrypoint
  namespace: default
spec:
  type: NodePort
  selector:
    bb: web
  ports:
  - port: 8080
    targetPort: 8080
    nodePort: 30001
```
